<?php

namespace App\Http\Controllers;

use App\Models\Request;
use App\Models\Address;
use Illuminate\Http\Request as HttpRequest;

class RequestController extends Controller
{

    public function getUserRequests($id)
    
{
    $requests = Request::where('user_id', $id)
        ->orderBy('created_at', 'desc')
        ->get(['id', 'description', 'status', 'origin_street', 'origin_number', 'destination_street', 'destination_number', 'stop_street', 'stop_number', 'amount', 'payment_method', 'created_at']);

    return response()->json($requests);
}


public function index()
{
    $requests = Request::with('status')->get();
    return response()->json($requests);
}



    
    public function store(HttpRequest $request)
    {
        // Validación
        $validated = $request->validate([
            'origin_street'      => 'required|string|max:255',
            'origin_number'      => 'required|string|max:30',
            'destination_street' => 'required|string|max:255',
            'destination_number' => 'required|string|max:30',
            'description'        => 'nullable|string',
            'payment_method'     => 'required|string|in:efectivo,mercadoPago,transferencia',
            'stop_street'        => 'nullable|string|max:255',
            'stop_number'        => 'nullable|string|max:30',
            'intersection'       => 'nullable|string|max:30',
            'floor'              => 'nullable|string|max:1',
            'department'         => 'nullable|string|max:3',
            'amount'             => 'nullable|numeric'
        ]);

     
        $origin = Address::create([
            'street'      => $validated['origin_street'],
            'number'      => $validated['origin_number'],
            'intersection'=> $validated['intersection'] ?? null,
            'floor'       => $validated['floor'] ?? null,
            'department'  => $validated['department'] ?? null,
            'user_id'     => auth()->id() ?? 1 // ⚠️ reemplazar por auth real
        ]);

      
        $destination = Address::create([
            'street'      => $validated['destination_street'],
            'number'      => $validated['destination_number'],
            'intersection'=> $validated['intersection'] ?? null,
            'floor'       => $validated['floor'] ?? null,
            'department'  => $validated['department'] ?? null,
            'user_id'     => auth()->id() ?? 1
        ]);

        $stop = null;
        if (!empty($validated['stop_street']) && !empty($validated['stop_number'])) {
            $stop = Address::create([
                'street'      => $validated['stop_street'],
                'number'      => $validated['stop_number'],
                'intersection'=> $validated['intersection'] ?? null,
                'floor'       => $validated['floor'] ?? null,
                'department'  => $validated['department'] ?? null,
                'user_id'     => auth()->id() ?? 1
            ]);
        }

        $newRequest = Request::create([
            'description'            => $validated['description'] ?? '',
            'payment_method'         => $validated['payment_method'],
            'user_id'                => auth()->id() ?? 1,
            'origin_address_id'      => $origin->id,
            'destination_address_id' => $destination->id,
            'stop_address_id'        => $stop?->id, // null si no existe
            'request_status_id'      => 1, // "Solicitada"
        ]);

        return response()->json([
            'message' => 'Solicitud creada con éxito',
            'data'    => $newRequest
        ], 201);
    }

    public function destroy($id)
{
    $request = Request::find($id);

    if (!$request) {
        return response()->json(['message' => 'Solicitud no encontrada'], 404);
    }

    $request->delete();

    return response()->json(['message' => 'Solicitud eliminada con éxito']);
}

public function update(Request $request, $id)
{
    $solicitud = Request::findOrFail($id);
    $solicitud->update($request->all());

    return response()->json($solicitud);
}

}
