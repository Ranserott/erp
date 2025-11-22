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
        Schema::table('calendario_pagos', function (Blueprint $table) {
            // Fix foreign key reference
            $table->dropForeign(['proveedor_id']);
            $table->foreign('proveedor_id')
                  ->references('id')
                  ->on('proveedores')
                  ->onDelete('cascade');

            // Rename fecha_vencimiento to fecha_pago for consistency
            $table->renameColumn('fecha_vencimiento', 'fecha_pago');

            // Add new fields
            $table->string('descripcion')->nullable()->after('titulo_servicio');
            $table->enum('recurrente', ['mensual', 'trimestral', 'semestral', 'anual', 'unico'])->default('unico')->after('fecha_pago');
            $table->integer('dias_recordatorio')->default(3)->after('recurrente');
            $table->boolean('recordatorio_enviado')->default(false)->after('dias_recordatorio');
            $table->text('notas_internas')->nullable()->after('estado');
            $table->string('tipo_pago')->default('transferencia')->after('monto'); // transferencia, cheque, efectivo, etc.
            $table->string('categoria')->nullable()->after('tipo_pago'); // servicios, materiales, alquiler, etc.

            // Add indexes
            $table->index(['fecha_pago', 'estado']);
            $table->index(['proveedor_id', 'fecha_pago']);
            $table->index(['categoria']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calendario_pagos', function (Blueprint $table) {
            // Drop new fields
            $table->dropColumn('descripcion');
            $table->dropColumn('recurrente');
            $table->dropColumn('dias_recordatorio');
            $table->dropColumn('recordatorio_enviado');
            $table->dropColumn('notas_internas');
            $table->dropColumn('tipo_pago');
            $table->dropColumn('categoria');

            // Drop indexes
            $table->dropIndex(['fecha_pago', 'estado']);
            $table->dropIndex(['proveedor_id', 'fecha_pago']);
            $table->dropIndex(['categoria']);

            // Rename back
            $table->renameColumn('fecha_pago', 'fecha_vencimiento');

            // Fix foreign key back
            $table->dropForeign(['proveedor_id']);
            $table->foreign('proveedor_id')
                  ->references('id')
                  ->on('proveedors')
                  ->onDelete('cascade');
        });
    }
};
