<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VehicleBrand; 
use App\Models\VehicleType; 


class Vehicle extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleFactory> */
    use HasFactory;
    /** Relacion una marca un vehiculo  */
    public function vehicleBrand()
    {
        return $this->hasOne('App\VehicleBrand');
    }
     /** Relacion un tipo un vehiculo  */
    public function vehicleType()
    {
        return $this->hasOne('App\VehicleType');
    }

    public function documents()
    {
    return $this->hasMany(VehicleDoc::class);
    }

    public function brand()
    {
    return $this->belongsTo(VehicleBrand::class,'vehicle_brand_id');
    }

    public function type()
    {
    return $this->belongsTo(VehicleType::class,'vehicle_type_id');
    }

    public function courier()
    {
    return $this->hasOne(Courier::class);
    }
    
}
