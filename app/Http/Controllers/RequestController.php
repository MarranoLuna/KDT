<?php

namespace App\Http\Controllers;

use App\Models\Request;
use App\Models\Address;
use Illuminate\Http\Request as HttpRequest;

class RequestController extends Controller
{
    public function store(HttpRequest $request)
    {
        $validated = $request->validate([
            'origin'         => 'required|string|max:255',
            'destination'    => 'required|string|max:255',
            'description'    => 'nullable|string',
            'payment_method' => 'required|string|in:efectivo,mercadoPago,transferencia',
            'stop'           => 'nullable|string|max:255',
            'amount'         => 'nullable|numeric'
        ]);

        $origin = Address::create([
            'address' => $validated['origin']
        ]);

        $destination = Address::create([
            'address' => $validated['destination']
        ]);

        $stop = null;
        if (!empty($validated['stop'])) {
            $stop = Address::create([
                'address' => $validated['stop']
            ]);
        }
 
        $newRequest = Request::create([
            'description'          => $validated['description'] ?? '',
            'payment_method'       => $validated['payment_method'],
            'user_id'              => 1,
            'origin_address_id'    => $origin->id,
            'destination_address_id' => $destination->id,
            'request_status_id'    => 1, // "Solicitada"
        ]);

        return response()->json([
            'message' => 'Solicitud creada con éxito',
            'data'    => $newRequest
        ], 201);
    }
}
