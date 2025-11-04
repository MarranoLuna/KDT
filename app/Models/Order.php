<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderStatus; 
use App\Models\Offer;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_status_id',
        'offer_id',
        'is_completed',
    ];

    // Relación con OrderStatus
    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    // Relación con Offer
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }


    public function rating()
    {
        return $this->hasOne(Rating::class);
    }

    public function courier()
{
    return $this->belongsTo(User::class, 'courier_id');
}
}
