<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePqrsTable extends Migration
{
    /**
     * Ejecutar la migración para crear la tabla pqrs.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pqrs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del remitente
            $table->string('email'); // Correo electrónico del remitente
            $table->enum('type', ['pregunta', 'queja', 'reclamo']); // Tipo de PQR
            $table->text('message'); // Mensaje enviado
            $table->string('status')->default('pendiente'); // Estado de la PQR
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Revertir la migración para eliminar la tabla pqrs.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pqrs');
    }
}