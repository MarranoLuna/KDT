<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Request as RequestModel;
use App\Models\Offer;
use App\Models\OrderStatus;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
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
     * Store a newly created resource in storage.
     */
    public function store(Request $httpRequest, RequestModel $request)
    {
        
        $validator = Validator::make($httpRequest->all(), [
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::user();
        $kdt = $user->courier;
        
        if (!$kdt) {
        return response()->json([
            'message' => 'El usuario no es un cadete verificado o falta la relación en el Modelo User.'
        ], 403); // 403 Forbidden es mejor que 500
    }

        $existingOffer = Offer::where('courier_id', $kdt->id)
            ->where('request_id', $request->id)
            ->first();

        if ($existingOffer) {
            return response()->json(['message' => 'Ya has enviado una oferta para esta solicitud.'], 409);
        }

        /// Obtener el KDT y para llegar a su ID y así guardarlo con "courier_id" = id del courier

        $offer = Offer::create([

            'price' => $httpRequest->price,
            'courier_id' => $kdt->id,
            'request_id' => $request->id,
        ]);
        $request->update(['request_status_id' => 2]);
        return response()->json($offer, 201);

        


        //  Obtenemos el USUARIO logueado
        ///$user = $httpRequest->user(); // o Auth::user() //-> ya se declaró más arriba

        //  Obtenemos su PERFIL de cadete usando la relación
        $user = Auth::user();
        $kdt = $user->courier;

        //  seguridad
        if (!$kdt) {
            return response()->json(['message' => 'El usuario no es un cadete registrado.'], 403);
        }

        //  Verificamos si ya ofertó (usando el ID del PERFIL)
        $existingOffer = Offer::where('courier_id', $kdt->id)
            ->where('request_id', $request->id)
            ->first();

        if ($existingOffer) {
            return response()->json(['message' => 'Ya has enviado una oferta para esta solicitud.'], 409);
        }

        //  Creamos la oferta (¡Ahora $kdt->id SÍ es el 'couriers.id'!)
        $offer = Offer::create([
            'price' => $httpRequest->price,
            'courier_id' => $kdt->id,
            'request_id' => $request->id,
        ]);

        $request->update(['request_status_id' => 2]);
        return response()->json($offer, 201);
    }




    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        //
    }
}
