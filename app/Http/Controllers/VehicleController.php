<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function storeBicycle(Request $request)
    {
        $user = Auth::user();
        $courier = $user->courier;

        $bicycle_type_id = 2;

        $vehicle = Vehicle::create([
            'color' => $request->color,
            'bicycle_brand_id' => $request->brand_id,
            'vehicle_type_id' => $bicycle_type_id,
            'courier_id' => $courier->id,
        ]);

        return response()->json($vehicle, 201);
    }


    public function storeMotorcycle(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'registration_plate' => 'required|string|max:10|unique:vehicles',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::user();
        $courier = $user->courier;

        $motorcycle_type_id = 1;

        $vehicle = Vehicle::create([
            'model' => $request->model,
            'color' => $request->color,
            'registration_plate' => $request->registration_plate,
            'motorcycle_brand_id' => $request->brand_id,
            'vehicle_type_id' => $motorcycle_type_id,
            'courier_id' => $courier->id,
        ]);

        return response()->json($vehicle, 201);
    }

    public function index()
    {
        $id = Auth::id();

        $vehicles = Vehicle::where('courier_id', $id)
            ->with([
                'vehicleType', 
                'bicycleBrand', 
                'motorcycleBrand'
            ])->get();
        return response()->json($vehicles);
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
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
