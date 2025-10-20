<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MotorcycleBrand; 
use App\Models\BicycleBrand;
use App\Models\VehicleType; 


class Vehicle extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleFactory> */
    use HasFactory;
    /** Relacion una marca un vehiculo  */
        public function motorcycleBrand()
    {
        return $this->belongsTo(MotorcycleBrand::class);
    }

    public function bicycleBrand()
    {
        return $this->belongsTo(BicycleBrand::class);
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

    public function type()
    {
    return $this->belongsTo(VehicleType::class,'vehicle_type_id');
    }

    public function courier()
    {
    return $this->hasOne(Courier::class);
    }
    
}
