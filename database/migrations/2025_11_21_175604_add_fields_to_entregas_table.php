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
            $table->string('numero_entrega')->unique()->after('id');
            $table->unsignedBigInteger('cliente_id')->nullable()->after('orden_trabajo_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('cliente_id');
            $table->dateTime('hora_entrega')->nullable()->after('fecha_entrega');
            $table->string('documento_receptor')->nullable()->after('nombre_receptor');
            $table->text('direccion_entrega')->nullable()->after('documento_receptor');
            $table->string('telefono_receptor')->nullable()->after('direccion_entrega');
            $table->enum('estado', ['pendiente', 'en_camino', 'entregado', 'rechazado', 'devuelto', 'cancelado'])->default('pendiente')->after('telefono_receptor');
            $table->json('evidencia_foto')->nullable()->change();
            $table->json('firma_digital')->nullable()->after('evidencia_foto');
            $table->json('coordenadas')->nullable()->after('firma_digital');
            $table->enum('tipo_entrega', ['completa', 'parcial', 'entrega_final'])->default('completa')->after('coordenadas');
            $table->enum('metodo_entrega', ['propia', 'externa', 'digital', 'retiro'])->default('propia')->after('tipo_entrega');
            $table->decimal('costo_envio', 10, 2)->nullable()->after('metodo_entrega');
            $table->text('notas_internas')->nullable()->after('costo_envio');

            // Foreign keys
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entregas', function (Blueprint $table) {
            $table->dropForeign(['cliente_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'numero_entrega',
                'cliente_id',
                'user_id',
                'hora_entrega',
                'documento_receptor',
                'direccion_entrega',
                'telefono_receptor',
                'estado',
                'firma_digital',
                'coordenadas',
                'tipo_entrega',
                'metodo_entrega',
                'costo_envio',
                'notas_internas'
            ]);
        });
    }
};
