<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'comment',
        'order_id',
    ];

    // Relación con Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
