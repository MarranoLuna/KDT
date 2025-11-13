<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderStatus;

class OrderController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $orders = Order::whereHas('offer.request', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with([ 
            'status', 
            'offer.courier', 
            'offer.request.originAddress', 
            'offer.request.destinationAddress' 
        ])
        ->latest() 
        ->get();

        return response()->json($orders);
    }

    public function completeOrder(Request $request, Order $order)
    {
        $user = $request->user();
        $courierProfile = $user->courier; // <obtenemos el PERFIL del cadete


        if (!$courierProfile) {
            return response()->json(['message' => 'Usuario no es un cadete'], 403);
        }
        
        $order->load('offer'); 

        // comparamos ID de Perfil con ID de Perfil
        if ($order->offer->courier_id !== $courierProfile->id) {
            return response()->json(['message' => 'No autorizado para esta acción'], 403);
        }

        $statusCompletada = OrderStatus::where('name', 'completada')->firstOrFail();
        
        $order->update([
            'order_status_id' => $statusCompletada->id,
            'is_completed' => true
        ]);

        return response()->json(['message' => '¡Pedido completado exitosamente!']);
    }

   
    public function getDetails(Request $request, Order $order)
    {
        $user = $request->user(); 
        $courierProfile = $user->courier; // obtenemos el PERFIL del cadete


        if (!$courierProfile) {
            return response()->json(['message' => 'Usuario no es un cadete'], 403);
        }

        $order->load('offer');

        // comparamos ID de Perfil con ID de Perfil
        if ($order->offer->courier_id !== $courierProfile->id) { 
            return response()->json(['message' => 'No autorizado'], 403);
        }

       
        $orderData = $order->load([
            'status',
            'offer.request',
            'offer.request.user',
            'offer.request.originAddress',
            'offer.request.destinationAddress'
        ]);

        return response()->json($orderData);
    }
}