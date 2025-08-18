<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle; 

class VehicleType extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleTypeFactory> */
    use HasFactory;
     /** Relacion un vehiculo un tipo */
    public function vehicle()
    {
        return $this->hasMany(Vehicle::class);
    }
}
