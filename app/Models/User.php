<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function gamepads()
    {
        return $this->hasMany(Gamepad::class);
    }

    public function queues()
    {
        return $this->belongsToMany(Queue::class, 'queue_users');
    }
    public function numbers()
    {
        return $this->hasMany(Number::class);
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'admin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function printReports()
    {
        return $this->hasMany(PrintReport::class);
    }

    public function attendants()
    {
        return $this->hasMany(Attendant::class);
    }
}
