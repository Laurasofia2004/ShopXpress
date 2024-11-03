<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // Identificador único para el artículo del pedido
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Relación con el pedido
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relación con el producto
            $table->integer('quantity'); // Cantidad del producto
            $table->decimal('price', 10, 2); // Precio del producto en el momento de la compra
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
        Schema::dropIfExists('order_items');
    }
}