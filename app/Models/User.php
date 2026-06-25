<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'bio',
        'location',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pontosTuristicos()
    {
        return $this->hasMany(PontoTuristico::class, 'user_id');
    }

    public function favoritos()
    {
        return $this->belongsToMany(PontoTuristico::class, 'favoritos', 'user_id', 'ponto_turistico_id')
            ->withTimestamps();
    }
}
