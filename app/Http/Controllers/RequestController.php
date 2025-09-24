<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request as HttpRequest; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Address; 
use App\Models\Request;  

class RequestController extends Controller
{
    public function store(HttpRequest $httpRequest)
    {
        // 1. Validar los datos que llegan desde Ionic
        $validator = Validator::make($httpRequest->all(), [
            'origin_address' => 'required|string|max:255',
            'origin_lat' => 'required|numeric',
            'origin_lng' => 'required|numeric',
            'destination_address' => 'required|string|max:255',
            'destination_lat' => 'required|numeric',
            'destination_lng' => 'required|numeric',
            'stop_address' => 'nullable|string|max:255',
            'stop_lat' => 'nullable|numeric',
            'stop_lng' => 'nullable|numeric',
            'description' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $validatedData = $validator->validated();
        $userId = Auth::id();

        // 2. Procesar las direcciones: buscar si ya existen o crearlas
        // Usamos updateOrCreate para evitar duplicados basados en las coordenadas
        $originAddress = Address::updateOrCreate(
            ['lat' => $validatedData['origin_lat'], 'lng' => $validatedData['origin_lng']],
            ['address' => $validatedData['origin_address'], 'user_id' => $userId]
        );

        $destinationAddress = Address::updateOrCreate(
            ['lat' => $validatedData['destination_lat'], 'lng' => $validatedData['destination_lng']],
            ['address' => $validatedData['destination_address'], 'user_id' => $userId]
        );

        $stopAddressId = null;
        if (!empty($validatedData['stop_address'])) {
            $stopAddress = Address::updateOrCreate(
                ['lat' => $validatedData['stop_lat'], 'lng' => $validatedData['stop_lng']],
                ['address' => $validatedData['stop_address'], 'user_id' => $userId]
            );
            $stopAddressId = $stopAddress->id;
        }

        // 3. Crear la solicitud (Request) con los IDs de las direcciones
        try {
            $newRequest = Request::create([
                'description' => $validatedData['description'],
                'payment_method' => $validatedData['payment_method'],
                'user_id' => $userId,
                'origin_address_id' => $originAddress->id,
                'destination_address_id' => $destinationAddress->id,
                'address_id' => $stopAddressId, 
                'request_status_id' => 1, 
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear la solicitud', 'error' => $e->getMessage()], 500);
        }

       
        return response()->json([
            'message' => 'Solicitud creada con éxito',
            'request' => $newRequest
        ], 201);
    }
}