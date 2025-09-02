<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 

class Address extends Model
{
     use HasFactory;

    protected $fillable = [
        'street',
        'number',
        'intersection',
        'floor',
        'department',
        'user_id',
    ];
    /**Relacion muchos usuarios  */
    public function users()
    {
        return $this->belongsTo('App\User');
    }
    /**Una direccion puede ser origen o destino de muchas requests */
    public function requestsAsOrigin()
    {
        return $this->hasMany(Request::class,'origin_adress_id');
    }
    public function requestsAsDestination()
    {
        return $this->hasMany(Request::class,'destination_address_id');
    }
}
