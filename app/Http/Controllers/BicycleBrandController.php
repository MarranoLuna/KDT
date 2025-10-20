<?php
namespace App\Http\Controllers;
use App\Models\BicycleBrand;
use Illuminate\Http\Request;

class BicycleBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        // Obtenemos todas las marcas, ordenadas alfabéticamente por nombre
        $brands = BicycleBrand::orderBy('name', 'asc')->get();

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
    public function show(BicycleBrand $bicycleBrand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BicycleBrand $bicycleBrand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BicycleBrand $bicycleBrand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BicycleBrand $bicycleBrand)
    {
        //
    }
}
