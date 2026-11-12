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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_orden', 20)->nullable()->unique();
            $table->unsignedBigInteger('usuario_id');
            $table->enum('estado', ['recibido', 'en_preparacion', 'despachado', 'entregado', 'cancelado'])->default('recibido');
            $table->decimal('total', 12, 2)->default(0);
            $table->enum('metodo_pago', ['transferencia', 'pasarela']);
            $table->string('nombre_destinatario', 120);
            $table->string('direccion_envio', 200);
            $table->string('ciudad_envio', 80);
            $table->string('telefono_contacto', 20);
            $table->string('motivo_cancelacion', 255)->nullable();
            $table->timestamps();

            $table->index('estado');
            $table->index('created_at');
            $table->foreign('usuario_id')->references('id')->on('users')->restrictOnDelete();
        });

        DB::statement('ALTER TABLE pedidos ADD CONSTRAINT ck_pedidos_total CHECK (total >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
