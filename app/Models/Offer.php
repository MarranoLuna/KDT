<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Request;
use App\Models\Courier;
use App\Models\User;


class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'courier_id',
        'request_id',
    ];

    // Relación con Courier
    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id');
    }


    // Relación con Request
    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    // Relación con Order (1 oferta puede estar en 1 pedido)
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function user()
{
    return $this->belongsTo(User::class, 'courier_id');
}
}
