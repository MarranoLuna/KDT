<?php

namespace App\Http\Controllers;

use App\Models\Request;
use App\Models\Address;
use Illuminate\Http\Request as HttpRequest;

class RequestController extends Controller
{
    
    public function index()
    {
        $requests = Request::with('status')->get();
        return response()->json($requests);
    }

   
    public function getUserRequests($id)
    {
        $requests = Request::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get([
                'id', 'description', 'request_status_id',
                'origin_address_id', 'destination_address_id',
                'stop_address_id', 'amount', 'payment_method', 'created_at'
            ]);

        return response()->json($requests);
    }

    public function store(HttpRequest $request)
    {
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
            'user_id'     => auth()->id() ?? 1
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
            'stop_address_id'        => $stop?->id,
            'request_status_id'      => 1, 
            'amount'                 => $validated['amount'] ?? null,
        ]);

        return response()->json([
            'message' => 'Solicitud creada con éxito',
            'data'    => $newRequest
        ], 201);
    }

    public function update(Request $request, $id)
{
    $req = RequestModel::findOrFail($id);

    
    if ($req->status !== 'solicitada') {
        return response()->json(['message' => 'Solo se pueden editar solicitudes en estado solicitada'], 403);
    }

    $validated = $request->validate([
        'description' => 'nullable|string|max:255',
        'origin_street' => 'nullable|string|max:255',
        'origin_number' => 'nullable|string|max:50',
        'destination_street' => 'nullable|string|max:255',
        'destination_number' => 'nullable|string|max:50',
        'payment_method' => 'nullable|string|in:efectivo,tarjeta,transferencia'
    ]);

    $req->update($validated);

    return response()->json([
        'message' => 'Solicitud actualizada correctamente',
        'request' => $req
    ]);
}

    public function destroy($id)
    {
        $solicitud = Request::find($id);

        if (!$solicitud) {
            return response()->json(['message' => 'Solicitud no encontrada'], 404);
        }

        $solicitud->delete();

        return response()->json(['message' => 'Solicitud eliminada con éxito']);
    }
}
