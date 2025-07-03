<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 

class Address extends Model
{
     use HasFactory;

    protected $fillable = [
        'street',
        'number',
        'intersection',
        'floor',
        'department',
        'user_id',
    ];
    /**Relacion muchos usuarios  */
    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
