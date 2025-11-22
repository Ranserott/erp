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
        Schema::table('cotizaciones', function (Blueprint $table) {
            // Hacer las columnas existentes nullable
            $table->date('fecha')->nullable()->change();
            $table->decimal('subtotal', 10, 2)->nullable()->change();
            $table->decimal('iva', 10, 2)->nullable()->change();
            $table->decimal('total', 10, 2)->nullable()->change();

            // Cambiar el enum a string
            $table->string('estado', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizaciones', function (Blueprint $table) {
            // Restaurar las columnas originales
            $table->date('fecha')->nullable(false)->change();
            $table->decimal('subtotal', 10, 2)->nullable(false)->change();
            $table->decimal('iva', 10, 2)->nullable(false)->change();
            $table->decimal('total', 10, 2)->nullable(false)->change();
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada'])->default('pendiente')->change();
        });
    }
};
