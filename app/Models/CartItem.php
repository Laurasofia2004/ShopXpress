<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price'
    ];

    /**
     * Relación con el modelo Cart.
     * Un elemento del carrito pertenece a un carrito.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Relación con el modelo Product.
     * Un elemento del carrito se relaciona con un producto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
