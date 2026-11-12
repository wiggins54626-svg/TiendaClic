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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('rol', ['cliente', 'colaborador', 'propietario'])->default('cliente')->after('password');
            $table->boolean('activo')->default(true)->after('rol');
            $table->boolean('acepta_politica_datos')->default(false)->after('activo');
            $table->dateTime('fecha_autorizacion_datos')->nullable()->after('acepta_politica_datos');
            $table->index('rol');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['rol']);
            $table->dropColumn(['rol', 'activo', 'acepta_politica_datos', 'fecha_autorizacion_datos']);
        });
    }
};
