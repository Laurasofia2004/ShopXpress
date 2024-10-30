<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginAttemptsTable extends Migration
{
    /**
     * Ejecutar la migración para crear la tabla login_attempts.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // ID del usuario
            $table->string('ip_address'); // Dirección IP desde donde se intentó el inicio de sesión
            $table->boolean('success'); // Indica si el intento fue exitoso
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Revertir la migración para eliminar la tabla login_attempts.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_attempts');
    }
}