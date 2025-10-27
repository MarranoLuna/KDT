<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    /** @use HasFactory<\Database\Factories\CourierFactory> */
    use HasFactory;

    protected $fillable = [
        'status',
        'user_id',
        'vehicle_id',
        'start_date',
        'dni',
        'is_validated',
        'balance',
        'dni_frente_path',
        'dni_dorso_path'
    ];
    
    protected $casts = [
        'start_date' => 'date',
    ];

    public function offers()
    {
    return $this->hasMany(Offer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }


}
