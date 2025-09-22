<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Almacena una nueva dirección en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
  
        $validatedData = $request->validate([
            'street' => 'required|string|max:255',
            'number' => 'nullable|string|max:255',
            'intersection' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
        ]);

        $address = new Address($validatedData);


        $address->user_id = Auth::id();

     
        $address->save();

        return response()->json([
            'message' => '¡Dirección guardada exitosamente!',
            'address' => $address
        ], 201);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
