<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class UserModel extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'usuarios';
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'contraseña',
        'rol',
        'estado',
    ];
    protected $hidden = [
        'contraseña',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'contraseña' => 'hashed',
            'estado' => 'boolean',
        ];
    }
    public function initials(): string
    {
        return Str::of($this->nombre . ' ' . $this->apellido)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }
}
