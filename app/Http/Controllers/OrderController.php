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

        // --- ¡ARREGLO! ---
        // 1. Cargamos la relación 'offer' ANTES de usarla.
        $order->load('offer'); 

        // 2. Ahora sí podemos hacer la verificación de seguridad
        if ($order->offer->courier_id !== $user->id) {
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

        // --- ¡ARREGLO! ---
        // 1. Cargamos la relación 'offer' ANTES de usarla.
        $order->load('offer');

        // 2. Ahora sí podemos hacer la verificación de seguridad
        if ($order->offer->courier_id !== $user->id) { 
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // 3. Si pasamos el guardia, cargamos el resto de los datos
        $orderData = $order->load([
            'status',
            // 'offer', // (ya la cargamos, pero no hace daño)
            'offer.request',
            'offer.request.user',
            'offer.request.originAddress',
            'offer.request.destinationAddress'
        ]);

        return response()->json($orderData);
    }
}