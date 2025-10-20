<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorcycleBrand extends Model
{
    /** @use HasFactory<\Database\Factories\MotorcycleBrandFactory> */
    use HasFactory;

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    
}
