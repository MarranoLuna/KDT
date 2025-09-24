<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AddressController extends Controller
{
    /**
     * Muestra las direcciones guardadas por un usuario.
     */
    public function index()
    {
       
        $userId = Auth::id();

        $addresses = Address::where('user_id', $userId)->latest()->get();

        return response()->json($addresses);
    }

    /**
     * Guarda una nueva dirección en la base de datos.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userId = Auth::id();

        // Usamos updateOrCreate para evitar guardar la misma dirección dos veces
        $address = Address::updateOrCreate(
            [
                'lat' => $request->lat,
                'lng' => $request->lng,
                'user_id' => $userId
            ],
            [
                'address' => $request->address,
            ]
        );

        return response()->json([
            'message' => 'Dirección guardada con éxito',
            'address' => $address
        ], 201);
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
        //
    }
}
