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
        Schema::table('ordenes_trabajo', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('cotizacion_id');
            $table->date('fecha_fin_real')->nullable()->after('fecha_fin_estimada');
            $table->enum('prioridad', ['baja', 'media', 'alta', 'urgente'])->default('media')->after('estado');
            $table->text('notas')->nullable()->after('prioridad');
            $table->decimal('costo_estimado', 10, 2)->nullable()->after('notas');
            $table->decimal('costo_real', 10, 2)->nullable()->after('costo_estimado');

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes_trabajo', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id',
                'fecha_fin_real',
                'prioridad',
                'notas',
                'costo_estimado',
                'costo_real'
            ]);
        });
    }
};
