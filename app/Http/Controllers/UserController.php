<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Validation\Rules\Password;
use App\Models\Order;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getMyOrders(Request $request)
    {
        $user = $request->user(); // Obtiene el CLIENTE logueado

        // Buscamos órdenes...
        $myOrders = Order::whereHas('offer.request', function ($query) use ($user) {
            // ...donde la 'request' asociada...
            // ...pertenezca a ESTE cliente ($user->id)
            $query->where('user_id', $user->id);
        })
        ->with([ // Cargamos las mismas relaciones que SÍ funcionan en tu HTML
            'status',
            'offer',
            'offer.courier', // El 'courier' (que es un User)
            'offer.request',
            'offer.request.originAddress',
            'offer.request.destinationAddress'
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json($myOrders);
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
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, User $user)
    {
        // 1. Validar los datos que vienen del formulario
        $validatedData = $request->validate([
            'firstname' => 'sometimes|string|max:255',
            'lastname'  => 'sometimes|string|max:255',
            'email'     => 'sometimes|email|unique:users,email,' . $user->id,
            'birthday'  => 'sometimes|date',
            'avatar'    => 'string|nullable', // Recibimos el avatar como string
            // No valides 'password' aquí
        ]);

        $avatarData = $validatedData['avatar'] ?? null;

        // --- 2. Lógica para guardar el avatar ---
        
        // Revisa si 'avatar' es una cadena Base64
        if ($avatarData && Str::startsWith($avatarData, 'data:image')) {
            
            // Separa el tipo de imagen (ej: 'image/jpeg') y los datos base64
            list($type, $data) = explode(';', $avatarData);
            list(, $data)      = explode(',', $data);
            
            // Decodifica el Base64
            $imageData = base64_decode($data);
            
            // Obtiene la extensión (ej: 'png', 'jpeg')
            $extension = explode('/', $type)[1];
            
            // Genera un nombre de archivo único
            $filename = 'avatars/' . $user->id . '_' . time() . '.' . $extension;
            
            // Guarda el archivo en el disco 'public'
            // Esto lo guarda en 'storage/app/public/avatars/...'
            Storage::disk('public')->put($filename, $imageData);
            
            // 4. Reemplaza el Base64 por la URL pública del archivo
            // 'Storage::url' genera: '/storage/avatars/...'
            $validatedData['avatar'] = Storage::url($filename);
        }

        // --- 3. Actualiza el usuario en la BD ---
        // 'update' llenará los campos y los guardará
        $user->update($validatedData);

        // --- 4. Devuelve el usuario actualizado ---
        // El frontend recibirá este objeto con la URL final del avatar
        return response()->json($user);
    }


    public function updatePassword(Request $request)
    {
        //  Validar SOLO los datos de contraseña
        $validatedData = $request->validate([
            'current_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'confirmed', // Busca 'new_password_confirmation'
                Password::min(8)->mixedCase()->numbers()
            ],
        ]);

        // Obtener el usuario que está haciendo la petición
        $user = $request->user();

        // Verificar que la contraseña actual sea correcta 
        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return response()->json([
                'message' => 'La contraseña actual es incorrecta.'
            ], 422); 
        }

        // Hashear y guardar la nueva contraseña 
        $user->password = Hash::make($validatedData['new_password']);
        $user->save();

        //  Devolver una respuesta de éxito
        return response()->json([
            'message' => 'Contraseña actualizada exitosamente.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $address)
    {
        //
    }

    public function toggleStatus(Request $request)
    {
        try {
            $user = $request->user();

            $courier = $user->courier; 
            

            if (!$courier) {
                return response()->json(['message' => 'Perfil de cadete no encontrado.'], 404);
            }
            $courier->status = !$courier->status;
            
            $courier->save();

            return response()->json([
                'message' => 'Estado actualizado correctamente.',
                'new_status' => $courier->status 
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el estado.'], 500);
        }
    }

    public function savePushToken(Request $request){

        try {
            $data = $request->all();
            $user = Auth::user(); //obtiene el usuario autenticado 
            $user->push_token = $data['push_token'];
            $user->save();
            $user = $user->fresh(); 
            if($user["push_token"] == $data["push_token"]){
                return response()->json(['success' => true, "message"=> "Token de notificaciones guardado correctamente", "user"=> $user],200);
            } else{
                return response()->json(['success' => false, "message"=> "Error al guardar el token de notificaciones","user"=> $user],500);
            }
        }catch (\Exception $e) {
            return response()->json(['success' => false,'message' => "Error al guardar el token de notificaciones"], 500);
        }
    }
}
