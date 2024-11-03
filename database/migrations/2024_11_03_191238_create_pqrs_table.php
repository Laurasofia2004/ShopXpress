<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePqrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pqrs', function (Blueprint $table) {
            $table->id(); // Identificador único para la PQR
            $table->string('user_name'); // Nombre del usuario que realiza la PQR
            $table->string('user_email'); // Correo electrónico del usuario
            $table->string('subject'); // Asunto de la PQR
            $table->text('message'); // Mensaje o descripción de la PQR
            $table->enum('status', ['pending', 'resolved', 'closed'])->default('pending'); // Estado de la PQR
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
        Schema::dropIfExists('pqrs');
    }
}
