<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Address; 
use App\Models\Role; 
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory,HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'firstname',
        'lastname',
        'password',
        'birthday',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    public function getAvatarAttribute($value)
    {
        // Si el valor en la BD es null, devuelve null.
        if (!$value) {
            return null;
        }

        // Si el valor ya es una URL completa (http://...), devuélvelo tal cual.
        if (Str::startsWith($value, 'http')) {
            return $value;
        }

        // Si es un path relativo (ej: /storage/avatars/...),
        // antepone la URL base de tu app (ej: https://miapi.com)
        // 'URL::to($value)' hace esto automáticamente.
        return URL::to($value);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /** Relaciones*/
    public function address()
    {
        return $this->hasMany('App\Address');
    }
    public function admin()
    {
    return $this->hasOne(Admin::class);
    }

     public function requests()
    {
        return $this->hasMany(Request::class);
    }

     public function courier()
    {
        return $this->hasOne(Courier::class);
    }

    public function role()
{
    return $this->belongsTo(Role::class);
}
}
