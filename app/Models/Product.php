<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'stock', 
        'category_id', 
        'image_path'
    ];

    /**
     * Relación con el modelo Category.
     * Un producto pertenece a una categoría.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}