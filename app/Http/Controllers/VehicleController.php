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
        $id_kdt = Auth::user()->courier->id;

        $vehicles = Vehicle::where('courier_id', $id_kdt)
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
    public function destroy(Request $request)
    {
        try {
            $request->validate([
                'vehicle_id' => 'required|integer|exists:vehicles,id'
            ]);
            $vehicle_id = $request->input('vehicle_id');
            $courier_id = Auth::user()->courier->id;

            $vehicle = Vehicle::where('id', $vehicle_id)
                ->where('courier_id', $courier_id)
                ->first();

            if (!$vehicle) {
                return response()->json(['success' => false,'message' => 'Vehículo no encontrado o no pertenece al usuario.'], 404);
            } else{
                $vehicle->delete();
                return response()->json(['success' => true, "message" => "Vehículo eliminado correctamente"], 200);
            }
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "Error al eliminar de vehículo"], 500);

        }
    }

    public function changeVehicle(Request $request)
    {
        try {
            $request->validate([
                'vehicle_id' => 'required|integer|exists:vehicles,id'
            ]);

            $vehicle_id = $request->input('vehicle_id');
            $courier_id = Auth::user()->courier->id;
            $vehicles = Vehicle::where('courier_id', $courier_id)->get();
            foreach ($vehicles as $v) {
                $v["is_selected"] = false;
                $v->save();
            }
            $selected_vehicle = Vehicle::find($vehicle_id);
            if ($selected_vehicle) {
                $selected_vehicle->is_selected = true;
                $selected_vehicle->save();
                return response()->json(['success' => true, "message" => "Vehículo en uso actualizado correctamente"], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "Error al cambiar de vehículo"], 500);

        }

    }
}
