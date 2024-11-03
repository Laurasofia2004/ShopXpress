<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Ejecutar la migración para crear la tabla products.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); // Nombre del producto
            $table->text('description')->nullable(); // Descripción del producto
            $table->decimal('price', 10, 2); // Precio del producto
            $table->integer('stock'); // Cantidad en stock
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Relación con categorías
            $table->string('image_path')->nullable(); // Ruta de la imagen del producto
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Revertir la migración para eliminar la tabla products.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
