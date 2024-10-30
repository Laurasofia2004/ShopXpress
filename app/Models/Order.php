<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'shipping_address',
        'payment_method'
    ];

    /**
     * Relación con el modelo User.
     * Un pedido pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el modelo OrderItem.
     * Un pedido puede tener múltiples elementos.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
