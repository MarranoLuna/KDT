<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    // Relación con Rating (un pedido puede tener una calificación)
    public function rating()
    {
        return $this->hasOne(Rating::class);
    }

}
