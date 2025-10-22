<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Request as RequestModel; 
use App\Models\Offer;
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

        $kdt = Auth::user();

    
    $existingOffer = Offer::where('courier_id', $kdt->id)
                            ->where('request_id', $request->id)
                            ->first(); 
    if ($existingOffer) {
        return response()->json(['message' => 'Ya has enviado una oferta para esta solicitud.'], 409);
    }

        $offer = Offer::create([
            'price'      => $httpRequest->price, 
            'courier_id' => $kdt->id,
            'request_id' => $request->id,    
        ]);
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
