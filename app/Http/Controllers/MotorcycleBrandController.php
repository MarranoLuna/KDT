<?php

namespace App\Http\Controllers;

use App\Models\MotorcycleBrand;
use Illuminate\Http\Request;

class MotorcycleBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        // Obtenemos todas las marcas, ordenadas alfabéticamente por nombre
        $brands = MotorcycleBrand::orderBy('name', 'asc')->get();

        // Devolvemos la lista como una respuesta JSON
        return response()->json($brands);
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
    public function show(MotorcycleBrand $motorcycleBrand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MotorcycleBrand $motorcycleBrand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MotorcycleBrand $motorcycleBrand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MotorcycleBrand $motorcycleBrand)
    {
        //
    }
}
