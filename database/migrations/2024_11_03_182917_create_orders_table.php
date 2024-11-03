<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Ejecutar la migración para crear la tabla orders.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con usuarios
            $table->decimal('total_amount', 10, 2); // Monto total del pedido
            $table->string('status'); // Estado del pedido (ej: 'pending', 'completed', 'cancelled')
            $table->text('shipping_address'); // Dirección de envío
            $table->string('payment_method'); // Método de pago
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Revertir la migración para eliminar la tabla orders.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

