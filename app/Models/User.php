<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',     // admin, kasir, pelanggan
        'address',  // alamat
        'phone',    // no hp
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Helper untuk cek role di Controller/Blade nanti
    // Contoh cara pakai: if($user->hasRole('admin')) { ... }
    public function hasRole($role)
    {
        return $this->role === $role;
    }
}