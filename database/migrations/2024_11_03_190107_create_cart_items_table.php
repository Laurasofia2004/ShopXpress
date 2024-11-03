<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id(); // Identificador único para el artículo del carrito
            $table->foreignId('cart_id')->constrained()->onDelete('cascade'); // Relación con el carrito
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relación con el producto
            $table->integer('quantity'); // Cantidad del producto
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}