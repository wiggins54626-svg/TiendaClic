<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historial_estados_pedido', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id');
            $table->enum('estado_anterior', ['recibido', 'en_preparacion', 'despachado', 'entregado', 'cancelado'])->nullable();
            $table->enum('estado_nuevo', ['recibido', 'en_preparacion', 'despachado', 'entregado', 'cancelado']);
            $table->unsignedBigInteger('usuario_id');
            $table->timestamp('created_at')->nullable();

            $table->foreign('pedido_id')->references('id')->on('pedidos')->restrictOnDelete();
            $table->foreign('usuario_id')->references('id')->on('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_estados_pedido');
    }
};
