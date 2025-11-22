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
        Schema::table('entregas', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['orden_trabajo_id']);

            // Re-add the foreign key with the correct table name
            $table->foreign('orden_trabajo_id')
                  ->references('id')
                  ->on('ordenes_trabajo')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entregas', function (Blueprint $table) {
            // Drop the corrected foreign key
            $table->dropForeign(['orden_trabajo_id']);

            // Re-add the original foreign key (constrained method)
            $table->foreignId('orden_trabajo_id')->constrained()->onDelete('cascade');
        });
    }
};
