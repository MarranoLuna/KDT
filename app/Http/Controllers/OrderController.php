<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

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
}