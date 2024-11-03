<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Ejecutar la migración para crear la tabla inventories.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // ID del producto
            $table->integer('quantity')->default(0); // Cantidad disponible en el inventario
            $table->string('location')->nullable(); // Ubicación del producto en el almacén
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Revertir la migración para eliminar la tabla inventories.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}

