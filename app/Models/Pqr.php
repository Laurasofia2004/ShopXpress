<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pqr extends Model
{
    use HasFactory;

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'name',
        'email',
        'type', // Tipo de PQR: Pregunta, Queja o Reclamo
        'message',
        'status' // Estado de la PQR (por ejemplo, 'pendiente', 'resuelta')
    ];
}
