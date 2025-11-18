<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Vehicle;


class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    private function saveBase64Image($base64String, $folder, $fileNamePrefix)
    {
        //  limpia el string base64
        // el string viene con "data:image/jpeg;base64," al inicio. Hay que quitarlo.
        @list($type, $data) = explode(';', $base64String);
        @list(, $data) = explode(',', $data);

        // si no tiene ese formato, puede que venga limpio
        if (!$data) {
            $data = $base64String;
        }

        // decodificar el string
        $imageData = base64_decode($data);

        if ($imageData === false) {
            throw new \Exception('Error al decodificar la imagen base64.');
        }

        // generar un nombre único y la extensión
        $extension = explode('/', explode(':', $type)[1])[1] ?? 'jpg'; // Extrae 'jpeg' o 'png'
        $fileName = $fileNamePrefix . '_' . Str::random(10) . '.' . $extension;

        // definir la ruta de guardado (privada)
        $path = $folder . '/' . $fileName;

        // guardar el archivo en el disco 'storage/app/dni'
        Storage::disk('local')->put($path, $imageData);

        // devolver solo la ruta relativa para guardarla en la BD
        return $path;
    }

    public function dni($fileName)
    {
        $path = "dni_images/{$fileName}";
        if (!Storage::exists($path)) {
            abort(404);
        }

        $file = Storage::disk('local')->get($path);
        $mime = Storage::disk('local')->mimeType($path);

        return response($file)
            ->header('Content-Type', $mime);
    }


    public function courierRegistration(Request $request)
    {
        //  Validar los datos 
        $validatedData = $request->validate([
            'dni' => 'required|string|max:8',
            'dni_frente_base64' => 'required|string',
            'dni_dorso_base64' => 'required|string',
        ]);

        //  Obtener el usuario 
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        try {
            //  Guardar las imágenes 
            $pathFrente = $this->saveBase64Image(
                $request->dni_frente_base64,
                'dni_images',
                'user_' . $user->id . '_frente'
            );

            $pathDorso = $this->saveBase64Image(
                $request->dni_dorso_base64,
                'dni_images',
                'user_' . $user->id . '_dorso'
            );

            // Lógica de Creación/Actualización 
            $courier = Courier::updateOrCreate(
                ['user_id' => $user->id], // Busca por este campo
                [
                    'dni' => $validatedData['dni'],
                    'dni_frente_path' => $pathFrente,
                    'dni_dorso_path' => $pathDorso,
                    // Asignando valores por defecto según tu migración
                    'status' => 0,
                    'is_validated' => 0,
                    'start_date' => now(),
                    'balance' => 0.00,
                    'area' => 8,
                ]
            );

            //  Devolver respuesta 
            return response()->json([
                'message' => 'Solicitud enviada, pendiente de validación.',
                'courier' => $courier
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al procesar las imágenes.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function toggleStatus(Request $request)
    {
        try {

            $user = $request->user();
            //  encontrar cadete asociado
            $courier = $user->courier;


            if (!$courier) {
                return response()->json(['message' => 'Perfil de cadete no encontrado.'], 404);
            }

            // invertir el estado 
            $courier->status = !$courier->status;
            $courier->save();


            return response()->json([
                'message' => 'Estado actualizado correctamente.',
                'new_status' => $courier->status
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el estado.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getActiveOrder(Request $request)
    {
        $user = $request->user();

        // obtenemos su PERFIL de cadete (¡crucial!)
        $courierProfile = $user->courier;

        // si no tiene perfil de cadete, no puede tener pedidos.
        if (!$courierProfile) {
            return response(null, 204);
        }

        $activeOrder = Order::where('is_completed', false)
            ->whereHas('offer', function ($query) use ($courierProfile) {

                //    con el ID del PERFIL de cadete.
                $query->where('courier_id', $courierProfile->id);
            })
            ->with([
                'status',
                'offer',
                'offer.request',
                'offer.request.user',
                'offer.request.originAddress',
                'offer.request.destinationAddress'
            ])
            ->first();

        if ($activeOrder) {
            return response()->json($activeOrder);
        }

        return response(null, 204);
    }


    public function getMyOrders(Request $request)
    {
        $courier = $request->user()->courier;
        if (!$courier) {
            return response()->json([]);
        }

        // estado "en Proceso" 
        $statusEnProcesoId = 1;

        $myOrders = Order::where('order_status_id', $statusEnProcesoId)
            ->whereHas('offer', function ($query) use ($courier) {

                $query->where('courier_id', $courier->id);
            })
            ->with([
                'status',
                'offer',
                'offer.courier',
                'offer.request',
                'offer.request.originAddress',
                'offer.request.destinationAddress'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($myOrders);
    }

    public function getOrderHistory(Request $request)
{
    $user = $request->user();
    
    $courierProfile = $user->courier; 
    
    if (!$courierProfile) { 
        return response()->json([]); 
    }

    $historyOrders = Order::where('is_completed', true)
        ->whereHas('offer', function ($query) use ($courierProfile) { 
            
       
            $query->where('courier_id', $courierProfile->id); 
        })
        ->with([
            'status',
            'offer',
            'offer.request',
            'offer.request.user',
            'offer.request.originAddress',
            'offer.request.destinationAddress'
        ])
        ->orderBy('updated_at', 'desc')
        ->get();


    return response()->json($historyOrders);
}

    public function getEarnings(Request $request)
    {
        $user = $request->user();
        $courierProfile = $user->courier;
        if (!$courierProfile) {
            return response()->json(['total_earnings' => 0, 'completed_orders' => []]);
        }

        $filter = $request->query('filter', 'total');


        $statusCompletada = OrderStatus::where('name', 'completada')->first();


        if (!$statusCompletada) {
            return response()->json(['message' => 'Error de servidor: No se encontró el estado "completada" en la BD.'], 500);
        }


        $query = Order::where('order_status_id', $statusCompletada->id)
            ->whereHas('offer', function ($query) use ($courierProfile) {
                $query->where('courier_id', $courierProfile->id);
            });

        if ($filter === 'today') {
            $query->whereToday('updated_at');
        }

        $completedOrders = $query->with([
            'offer:id,price,request_id',
            'offer.request:id,title'
        ])
            ->orderBy('updated_at', 'desc')
            ->get();

        $totalEarnings = $completedOrders->sum(function ($order) {
            return $order->offer->price;
        });

        return response()->json([
            'total_earnings' => $totalEarnings,
            'completed_orders' => $completedOrders
        ]);
    }

    public function validate(Request $request)
    {
        try {
            //  No verifica que el user sea admin, falta agregar middleware
            $id = $request->id;
            $courier = Courier::find($id);
            $courier->is_validated = true;
            $user = $courier->user;
            $user->role_id = 2;
            $user->save();
            $courier->save();
            //  Devolver respuesta 
            return response()->json([
                'message' => 'Cadete habilitado',
                'courier' => $courier
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al habilitar el cadete',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function reject(Request $request)
    {
        try {
            //  No verifica que el user sea admin, falta agregar middleware
            $id = $request->id;
            $courier = Courier::with('vehicles', 'user')->findOrFail($id);
            $user = $courier->user;

            if (!$courier->is_validated) {
                foreach ($courier->vehicles as $vehicle) {
                    $vehicle->delete();
                }
                $courier->delete();
            }
            //  Devolver respuesta 
            return response()->json([
                'message' => 'Cadete rechazado',
                'user' => $user
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => "error al eliminar cadete",
                'error' => $e->getMessage()
            ], 500);
        }

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Courier $courier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Courier $courier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Courier $courier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Courier $courier)
    {
        //
    }
}
