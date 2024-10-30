<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Ejecutar la migración para crear la tabla categories.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique(); // Nombre de la categoría
            $table->text('description')->nullable(); // Descripción de la categoría
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Revertir la migración para eliminar la tabla categories.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
