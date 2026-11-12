<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id');
            $table->enum('metodo', ['transferencia', 'pasarela']);
            $table->enum('estado', ['pendiente', 'confirmado', 'rechazado'])->default('pendiente');
            $table->decimal('monto', 12, 2);
            $table->string('referencia_transaccion', 100)->nullable()->unique();
            $table->string('comprobante_ruta', 255)->nullable();
            $table->unsignedBigInteger('verificado_por')->nullable();
            $table->dateTime('fecha_pago')->nullable();
            $table->timestamps();

            $table->index('estado');
            $table->foreign('pedido_id')->references('id')->on('pedidos')->restrictOnDelete();
            $table->foreign('verificado_por')->references('id')->on('users')->restrictOnDelete();
        });

        DB::statement('ALTER TABLE pagos ADD CONSTRAINT ck_pagos_monto CHECK (monto >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
