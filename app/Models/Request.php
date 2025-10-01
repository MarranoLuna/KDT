<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    /**
     * Los campos que se pueden asignar masivamente.
     * Coinciden con los nombres de tus columnas, incluyendo los typos.
     */
    protected $fillable = [
        'description',
        'payment_method',
        'user_id',
        'origin_address_id',      
        'destination_address_id', 
        'request_status_id',      
    ];

    /**
     * Relación con la dirección de origen.
     */
    public function originAddress()
    {
        return $this->belongsTo(Address::class, 'origin_address_id');
    }

    /**
     * Relación con la dirección de destino.
     */
    public function destinationAddress()
    {
        return $this->belongsTo(Address::class, 'destination_address_id');
    }

    /**
     * Relación con el estado de la solicitud.
     */
    public function status()
    {
        return $this->belongsTo(RequestStatus::class, 'request_satus_id');
    }

    /**
     * Relación con el usuario que creó la solicitud.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con las ofertas recibidas.
     */
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
    
    /**
     * Relación con la dirección de parada (opcional).
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}