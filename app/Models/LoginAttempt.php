<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    use HasFactory;

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'user_id',      // ID del usuario que intentó iniciar sesión
        'ip_address',   // Dirección IP desde donde se intentó el inicio de sesión
        'success',      // Indica si el intento fue exitoso o no
        'created_at',   // Fecha y hora del intento
    ];

    // Definir relación con el modelo User (opcional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}