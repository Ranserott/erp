<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Proveedor;
use App\Models\Cotizacion;
use App\Models\ItemCotizacion;
use App\Models\OrdenTrabajo;
use App\Models\Factura;
use App\Models\Entrega;
use App\Models\CalendarioPago;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Llamar al AdminSeeder
        $this->call(AdminSeeder::class);

        // Crear clientes
        $clientes = Cliente::factory(15)->create();

        // Crear proveedores
        $proveedores = Proveedor::factory(8)->create();

        // Crear cotizaciones
        $cotizaciones = [];
        foreach ($clientes as $cliente) {
            $numCotizaciones = rand(1, 3);
            for ($i = 0; $i < $numCotizaciones; $i++) {
                $cotizacion = Cotizacion::factory()->create([
                    'cliente_id' => $cliente->id,
                    'fecha' => now()->subDays(rand(1, 60)),
                ]);
                $cotizaciones[] = $cotizacion;

                // Temporalmente sin items para cotización
                // $numItems = rand(1, 3);
                // for ($j = 0; $j < $numItems; $j++) {
                //     ItemCotizacion::factory()->create([
                //         'cotizacion_id' => $cotizacion->id,
                //     ]);
                // }
            }
        }

        // Crear órdenes de trabajo
        $ordenesTrabajo = [];
        foreach ($clientes as $cliente) {
            $numOrdenes = rand(0, 2);
            for ($i = 0; $i < $numOrdenes; $i++) {
                $cotizacion = !empty($cotizaciones) ? $cotizaciones[array_rand($cotizaciones)] : null;

                $orden = OrdenTrabajo::factory()->create([
                    'cliente_id' => $cliente->id,
                    'cotizacion_id' => $cotizacion ? $cotizacion->id : null,
                    'fecha_inicio' => now()->subDays(rand(1, 30)),
                ]);
                $ordenesTrabajo[] = $orden;
            }
        }

        // Crear facturas
        foreach ($clientes as $cliente) {
            $numFacturas = rand(0, 3);
            for ($i = 0; $i < $numFacturas; $i++) {
                $ordenTrabajo = OrdenTrabajo::where('cliente_id', $cliente->id)->inRandomOrder()->first();

                Factura::factory()->create([
                    'cliente_id' => $cliente->id,
                    'orden_trabajo_id' => $ordenTrabajo ? $ordenTrabajo->id : null,
                    'fecha_emision' => now()->subDays(rand(1, 45)),
                ]);
            }
        }

        // Crear entregas
        foreach ($ordenesTrabajo as $orden) {
            if (rand(0, 1)) { // 50% de probabilidad de tener entrega
                Entrega::factory()->create([
                    'orden_trabajo_id' => $orden->id,
                    'fecha_entrega' => $orden->fecha_inicio->addDays(rand(1, 20)),
                ]);
            }
        }

        // Crear calendario de pagos
        foreach ($proveedores as $proveedor) {
            $numPagos = rand(1, 4);
            for ($i = 0; $i < $numPagos; $i++) {
                CalendarioPago::factory()->create([
                    'proveedor_id' => $proveedor->id,
                    'fecha_vencimiento' => now()->addDays(rand(-10, 60)),
                ]);
            }
        }
    }
}
