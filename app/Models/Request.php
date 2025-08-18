<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    /** @use HasFactory<\Database\Factories\RequestFactory> */
    use HasFactory;


    public function origin()
    {
        return $this->belongsTo(Adress::class, 'origin_address_id');
    }
     public function destination()
    {
        return $this->belongsTo(Adress::class, 'destination_address_id');
    }

     public function status()
    {
        return $this->belongsTo(RequestStatus::class, 'request_status_id');
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }
     public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}
