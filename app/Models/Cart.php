<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'user_id',
        'total_amount'
    ];

    /**
     * Relación con el modelo User.
     * Un carrito pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el modelo CartItem.
     * Un carrito puede tener múltiples elementos.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
