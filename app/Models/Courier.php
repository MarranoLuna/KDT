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
        'start_date',
        'dni',
        'id_validated',
        'balance'
    ];
    
    protected $casts = [
        'start_date' => 'date',
    ];

}
