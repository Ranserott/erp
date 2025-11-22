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
            if (!Schema::hasColumn('cotizaciones', 'codigo')) {
                $table->string('codigo')->nullable();
            }
            if (!Schema::hasColumn('cotizaciones', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable();
            }
            if (!Schema::hasColumn('cotizaciones', 'asunto')) {
                $table->string('asunto')->nullable();
            }
            if (!Schema::hasColumn('cotizaciones', 'descripcion')) {
                $table->text('descripcion')->nullable();
            }
            if (!Schema::hasColumn('cotizaciones', 'monto')) {
                $table->decimal('monto', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('cotizaciones', 'vigencia')) {
                $table->date('vigencia')->nullable();
            }
            if (!Schema::hasColumn('cotizaciones', 'condiciones')) {
                $table->text('condiciones')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->dropColumn([
                'codigo',
                'user_id',
                'asunto',
                'descripcion',
                'monto',
                'vigencia',
                'condiciones'
            ]);
        });
    }
};
