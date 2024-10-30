<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Ejecutar la migración para crear la tabla order_items.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Relación con pedidos
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relación con productos
            $table->integer('quantity'); // Cantidad del producto en el pedido
            $table->decimal('price', 10, 2); // Precio del producto al momento del pedido
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Revertir la migración para eliminar la tabla order_items.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
