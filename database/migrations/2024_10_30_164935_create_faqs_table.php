<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    /**
     * Ejecutar la migración para crear la tabla faqs.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question'); // Pregunta frecuente
            $table->text('answer'); // Respuesta a la pregunta
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Revertir la migración para eliminar la tabla faqs.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faqs');
    }
}