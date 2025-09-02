<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
