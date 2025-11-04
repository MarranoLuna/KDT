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

    protected $fillable = [
        'model',
        'color',
        'registration_plate',
        'is_validated',
        'vehicle_type_id',
        'motorcycle_brand_id',
        'bicycle_brand_id',
        'courier_id',
    ];

        public function motorcycleBrand()
    {
        return $this->belongsTo(MotorcycleBrand::class);
    }

    public function bicycleBrand()
    {
        return $this->belongsTo(BicycleBrand::class);
    }

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
