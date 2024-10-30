<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Campos que se pueden llenar masivamente
    protected $fillable = ['name', 'description'];

    /**
     * Relación con el modelo Product.
     * Una categoría puede tener múltiples productos.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
