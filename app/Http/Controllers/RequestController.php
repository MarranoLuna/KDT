<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Request as RequestModel;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\RequestStatus;
use App\Models\User;

class RequestController extends Controller
{
    public function index()
    {
        $requests = RequestModel::where('user_id', Auth::id())

            ->whereIn('request_status_id', [1, 2])
            ->with(['originAddress', 'destinationAddress', 'status'])
            ->latest()
            ->get();

        return response()->json($requests);
    }


    public function store(HttpRequest $httpRequest)
    {
        $data = $httpRequest->all();
        $validator = Validator::make($data, [
            'title' => 'required|string|max:128',
            'origin_address' => 'required|string|max:255',
            'origin_lat' => 'required|numeric',
            'origin_lng' => 'required|numeric',
            'destination_address' => 'required|string|max:255',
            'destination_lat' => 'required|numeric',
            'destination_lng' => 'required|numeric',
            'stop_address' => 'nullable|string|max:255',
            'stop_lat' => 'nullable|numeric',
            'stop_lng' => 'nullable|numeric',
            'description' => 'required|string',
            'payment_method' => 'required|string',
            // ... otros campos como 'amount' ...
        ]);

        if ($validator->fails()) {
            //Si el validador falla, retorna los errores
            return response()->json($validator->errors(), 422);
        } else {
            //El validador NO falla:
            $user = Auth::user(); // obtiene el usuario que se autenticó por el token
            //se buscan y si no existen, se crean las direcciones
            $originAddress = $this->findOrCreateAddress($data, 'origin', $user->id);
            $destinationAddress = $this->findOrCreateAddress($data, 'destination', $user->id);

            ////----------------- LAS PARADAS NO ESTÁN DISEÑADAS EN LA BASE DE DATOS -----------------////
            /*
                $stopAddress = null;
                if (!empty($data['stop_address'])) {
                    $stopAddress = $this->findOrCreateAddress($data, 'stop', $user->id);
                }
            */

            //  CREAR LA SOLICITUD
            $newRequest = RequestModel::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'payment_method' => $data['payment_method'],
                'user_id' => $user->id,
                'origin_address_id' => $originAddress->id,
                'destination_address_id' => $destinationAddress->id,
                'request_status_id' => 1,
            ]);

            return response()->json($newRequest, 201);///-------------------------------------------// aca estamos
        }


    }

    private function findOrCreateAddress(array $data, string $prefix, int $userId): Address
    {

        $components = $data[$prefix . '_components'] ?? [];

        $street = collect($components)->firstWhere('types', ['route'])['long_name'] ?? null;
        $number = collect($components)->firstWhere('types', ['street_number'])['long_name'] ?? null;

        return Address::updateOrCreate(
            [
                'lat' => $data[$prefix . '_lat'],
                'lng' => $data[$prefix . '_lng'],
                'user_id' => $userId,
            ],
            [
                'address' => $data[$prefix . '_address'],
                'street' => $street,
                'number' => $number,
            ]
        );
    }


    public function update(HttpRequest $httpRequest, RequestModel $request)
    {

        if (Auth::id() !== $request->user_id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }


        $validator = Validator::make($httpRequest->all(), [
            'description' => 'sometimes|required|string',
            'payment_method' => 'sometimes|required|string',
            'stop_address' => 'nullable|string|max:255',
            'stop_lat' => 'nullable|numeric|required_with:stop_address',
            'stop_lng' => 'nullable|numeric|required_with:stop_address',
            'stop_components' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $httpRequest->all();
        $request->description = $data['description'];
        $request->payment_method = $data['payment_method'];


        if (isset($data['stop_address']) && !empty($data['stop_address'])) {
            $stopAddress = $this->findOrCreateAddress($data, 'stop', Auth::id());
            $request->address_id = $stopAddress->id;
        } else {
            $request->address_id = null;
        }

        $request->save();


        return response()->json($request->load(['originAddress', 'destinationAddress', 'status', 'address']));
    }


    public function destroy(RequestModel $request)
    {

        if (Auth::id() !== $request->user_id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $request->delete();

        return response()->json(null, 204);
    }


    public function availableForKdt() // para que kdt vea todas las solicitudes
    {
        $kdtId = Auth::id();

        $requests = RequestModel::whereIn('request_status_id', [1, 2])
            ->with([
                'originAddress',
                'destinationAddress',

                'user',
                'offers' => function ($query) use ($kdtId) {
                    $query->where('courier_id', $kdtId);
                }
            ])
            ->latest()
            ->get();
        $requests->each(function ($request) {
            $request->has_offered = $request->offers->isNotEmpty();
        });

        return response()->json($requests);
    }

    public function showOffers(RequestModel $request)
    {
        if (Auth::id() !== $request->user_id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $offers = $request->offers()->with('courier')->get();
        return response()->json($offers);
    }

    public function acceptOffer(RequestModel $request, Offer $offer)
    {

        if (Auth::id() !== $request->user_id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        if ($offer->request_id !== $request->id) {
            return response()->json(['message' => 'Oferta inválida'], 422);
        }
        if (!in_array($request->request_status_id, [1, 2])) {
            return response()->json(['message' => 'Esta solicitud ya no puede aceptar ofertas.'], 409);
        }


        $request->update(['request_status_id' => 3]);


        $order = Order::create([
            'offer_id' => $offer->id,
            'order_status_id' => 1,
            'is_completed' => false,
        ]);

        // 4. rechaza las otras ofertas - falta poner 'rechazada' eb BD
        //Offer::where('request_id', $request->id)
        //    ->where('id', '!=', $offer->id)
        //     ->whereNull('status') 
        //    ->update(['status' => 'rechazada']); 


        return response()->json([
            'message' => '¡Oferta aceptada! El pedido ha sido creado.',
            'order' => $order->load('offer.courier')
        ]);
    }

}