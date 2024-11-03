<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'product_id',   // ID del producto relacionado
        'quantity',     // Cantidad disponible en el inventario
        'location',     // Ubicación del producto en el almacén (opcional)
    ];

    // Definir relación con el modelo Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
