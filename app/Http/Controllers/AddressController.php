<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Models\Request; 
use Illuminate\Http\Request as HttpRequest; 
use Illuminate\Support\Facades\Validator;


class AddressController extends Controller
{
    /**
     * Muestra las direcciones guardadas por un usuario.
     */
    public function index()
    {
       
       $addresses = Address::where('user_id', Auth::id())->latest()->get();

        return response()->json($addresses);
    }

    /**
     * Guarda una nueva dirección en la base de datos.
     */
    public function store(HttpRequest $request)
    {
        
        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'address_components' => 'nullable|array', 
            'intersection' => 'nullable|string|max:30',
            'floor' => 'nullable|string|max:1',
            'department' => 'nullable|string|max:3',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userId = Auth::id();

        

    // extraer calle y número 
    $street = '';
    $number = '';
     if ($request->has('address_components')) {
        foreach ($request->address_components as $component) {
            if (in_array('route', $component['types'])) {
                $street = $component['long_name'];
            }
            if (in_array('street_number', $component['types'])) {
                $number = $component['long_name'];
            }
        }
    }

    if (empty($street)) {
        return response()->json(['message' => 'No se pudo determinar el nombre de la calle a partir de la ubicación.'], 422);
    }
    
   $address = Address::updateOrCreate(
            ['lat' => $request->lat, 'lng' => $request->lng, 'user_id' => $userId],
            [
                'address' => $request->address,
                'intersection' => $request->intersection,
                'floor' => $request->floor,
                'department' => $request->department,
               
                'street' => $street,
                'number' => $number,
            ]
        );

        return response()->json(['message' => 'Dirección guardada con éxito', 'address' => $address], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
   
    if (Auth::id() !== $address->user_id) {
        return response()->json(['message' => 'No autorizado'], 403);
    }

    
    $isBeingUsed = Request::where('origin_address_id', $address->id)
                           ->orWhere('destination_address_id', $address->id)
                           ->exists();

    if ($isBeingUsed) {
       
        return response()->json(['message' => 'Esta dirección no se puede eliminar porque está en uso en una o más solicitudes.'], 409);
    }

    $address->delete();

    return response()->json(null, 204);
}
}
