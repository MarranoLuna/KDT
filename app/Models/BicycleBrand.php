<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BicycleBrand extends Model
{
    /** @use HasFactory<\Database\Factories\BicycleBrandFactory> */
    use HasFactory;

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
