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
        Schema::create('pedido_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('producto_id');
            $table->string('nombre_producto', 150);
            $table->decimal('precio_unitario', 12, 2);
            $table->unsignedInteger('cantidad');
            $table->decimal('subtotal', 12, 2);

            $table->foreign('pedido_id')->references('id')->on('pedidos')->restrictOnDelete();
            $table->foreign('producto_id')->references('id')->on('productos')->restrictOnDelete();
        });

        DB::statement('ALTER TABLE pedido_items ADD CONSTRAINT ck_pedido_items_cantidad CHECK (cantidad > 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_items');
    }
};
