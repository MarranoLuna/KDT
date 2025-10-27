<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


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
    // 1. Limpiar el string base64
    // El string viene con "data:image/jpeg;base64," al inicio. Hay que quitarlo.
    @list($type, $data) = explode(';', $base64String);
    @list(, $data)      = explode(',', $data);
    
    // Si no tiene ese formato, puede que venga limpio
    if (!$data) {
        $data = $base64String;
    }

    // 2. Decodificar el string
    $imageData = base64_decode($data);
    
    if ($imageData === false) {
        throw new \Exception('Error al decodificar la imagen base64.');
    }

    // 3. Generar un nombre único y la extensión
    $extension = explode('/', explode(':', $type)[1])[1] ?? 'jpg'; // Extrae 'jpeg' o 'png'
    $fileName = $fileNamePrefix . '_' . Str::random(10) . '.' . $extension;
    
    // 4. Definir la ruta de guardado (privada)
    $path = $folder . '/' . $fileName;

    // 5. Guardar el archivo en el disco 'storage/app/dni'
    Storage::disk('local')->put($path, $imageData);

    // 6. Devolver solo la ruta relativa para guardarla en la BD
    return $path;
}



public function courierRegistration(Request $request)
    {
        // 1. Validar los datos 
    $validatedData = $request->validate([
        'dni' => 'required|string|max:8', // Ajustado a max:8
        'dni_frente_base64' => 'required|string',
        'dni_dorso_base64' => 'required|string',
    ]);

    // 2. Obtener el usuario 
    /** @var \App\Models\User $user */
    $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        try {
            // 3. Guardar las imágenes 
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

            // 4. Lógica de Creación/Actualización 
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
                    'balance' => 0.00
                ]
            );

            // 5. Devolver respuesta 
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
