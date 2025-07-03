<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle; 

class VehicleBrand extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleBrandFactory> */
    use HasFactory;
    /** Relacion un vehiculo una marca */
    public function vehicle()
    {
        return $this->hasOne('App\Vehicle');
    }
}
