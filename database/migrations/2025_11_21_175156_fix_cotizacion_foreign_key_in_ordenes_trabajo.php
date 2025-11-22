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
        // Eliminar la foreign key incorrecta
        Schema::table('ordenes_trabajo', function (Blueprint $table) {
            $table->dropForeign(['cotizacion_id']);
        });

        // Volver a crear la foreign key con la tabla correcta
        Schema::table('ordenes_trabajo', function (Blueprint $table) {
            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la foreign key correcta
        Schema::table('ordenes_trabajo', function (Blueprint $table) {
            $table->dropForeign(['cotizacion_id']);
        });

        // Volver a crear la foreign key incorrecta (para rollback)
        Schema::table('ordenes_trabajo', function (Blueprint $table) {
            $table->foreign('cotizacion_id')->references('id')->on('cotizacions')->onDelete('set null');
        });
    }
};
