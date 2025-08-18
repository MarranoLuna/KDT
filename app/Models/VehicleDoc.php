<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleDoc extends Model
{
     use HasFactory;

    protected $fillable = [
        'link',
        'vehicle_id',
    ];

    // Relación con Vehicle
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
