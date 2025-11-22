<?php

namespace App\Http\Controllers;

use App\Models\CalendarioPago;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CalendarioPagoController extends Controller
{
    public function __construct()
    {
        // No se necesita middleware aquí, se maneja en las rutas
    }

    public function index(Request $request)
    {
        $query = CalendarioPago::with('proveedor');

        // Filtros
        if ($request->filled('proveedor_id')) {
            $query->porProveedor($request->proveedor_id);
        }

        if ($request->filled('categoria')) {
            $query->porCategoria($request->categoria);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('mes')) {
            $query->delMes($request->mes, $request->anio ?: now()->year);
        }

        // Ordenamiento
        $query->orderBy('fecha_pago', 'asc');

        $pagos = $query->paginate(50);

        // Datos para filtros
        $proveedores = Proveedor::orderBy('nombre')->get();
        $categorias = CalendarioPago::CATEGORIAS;
        $estados = CalendarioPago::ESTADOS;

        return view('calendario-pagos.index', compact(
            'pagos',
            'proveedores',
            'categorias',
            'estados'
        ));
    }

    public function calendario(Request $request)
    {
        $anio = $request->get('anio', now()->year);
        $mes = $request->get('mes', now()->month);

        // Obtener pagos del mes
        $pagos = CalendarioPago::with('proveedor')
            ->delMes($mes, $anio)
            ->get();

        // Obtener estadísticas del mes
        $stats = [
            'total' => $pagos->count(),
            'pendientes' => $pagos->where('estado', 'pendiente')->count(),
            'pagados' => $pagos->where('estado', 'pagado')->count(),
            'vencidos' => $pagos->where(function($p) {
                return $p->fecha_pago->isPast() && $p->estado !== 'pagado';
            })->count(),
            'monto_total' => $pagos->sum('monto'),
            'monto_pendiente' => $pagos->where('estado', 'pendiente')->sum('monto'),
        ];

        // Generar datos del calendario
        $calendar = $this->generateCalendarData($anio, $mes, $pagos);

        // Lista de meses disponibles
        $mesesDisponibles = CalendarioPago::selectRaw('DISTINCT strftime("%Y-%m", fecha_pago) as mes_anio')
            ->orderBy('mes_anio', 'desc')
            ->pluck('mes_anio')
            ->mapWithKeys(function($item) {
                $parts = explode('-', $item);
                return [
                    'mes' => (int)$parts[1],
                    'anio' => (int)$parts[0],
                    'nombre' => Carbon::createFromDate((int)$parts[0], (int)$parts[1], 1)->locale('es')->monthName
                ];
            });

        // Proveedores para filtros
        $proveedores = Proveedor::orderBy('nombre')->get();
        $categorias = CalendarioPago::CATEGORIAS;

        $nombreMes = Carbon::createFromDate($anio, $mes, 1)->locale('es')->monthName;

        return view('calendario-pagos.calendario', compact(
            'calendar',
            'stats',
            'anio',
            'mes',
            'mesesDisponibles',
            'proveedores',
            'categorias',
            'nombreMes'
        ));
    }

    private function generateCalendarData($anio, $mes, $pagos)
    {
        $carbon = Carbon::createFromDate($anio, $mes, 1);
        $daysInMonth = $carbon->daysInMonth;
        $firstDayOfWeek = $carbon->dayOfWeek - 1; // 0 = Sunday, 6 = Saturday
        $calendar = [];

        // Agregar días vacíos al inicio del mes
        for ($i = 0; $i < $firstDayOfWeek; $i++) {
            $calendar[] = ['day' => null, 'pagos' => []];
        }

        // Agregar días del mes con sus pagos
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($anio, $mes, $day);
            $dayPagos = $pagos->filter(function($pago) use ($date, $day) {
                return $pago->fecha_pago->day == $day;
            });

            $calendar[] = [
                'day' => $day,
                'date' => $date,
                'pagos' => $dayPagos,
                'is_today' => $date->isToday(),
                'is_weekend' => in_array($date->dayOfWeek, [0, 6]), // Sunday = 0, Saturday = 6
                'has_vencido' => $dayPagos->contains(function($pago) {
                    return $pago->esta_vencido;
                }),
                'has_proximo' => $dayPagos->contains(function($pago) {
                    return $pago->es_proximo;
                })
            ];
        }

        return $calendar;
    }

    public function create()
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        $tiposPago = CalendarioPago::TIPOS_PAGO;
        $categorias = CalendarioPago::CATEGORIAS;
        $recurrentes = CalendarioPago::RECURRENTES;

        // Pre-cargar datos si vienen de un proveedor específico
        $proveedorId = request('proveedor_id');
        $proveedor = $proveedorId ? Proveedor::find($proveedorId) : null;

        return view('calendario-pagos.create', compact(
            'proveedores',
            'tiposPago',
            'categorias',
            'recurrentes',
            'proveedor'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo_servicio' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'proveedor_id' => 'required|exists:proveedores,id',
            'monto' => 'required|numeric|min:0|max:999999999.99',
            'fecha_pago' => 'required|date|after_or_equal:today',
            'tipo_pago' => 'required|in:' . implode(',', array_keys(CalendarioPago::TIPOS_PAGO)),
            'categoria' => 'nullable|in:' . implode(',', array_keys(CalendarioPago::CATEGORIAS)),
            'recurrente' => 'required|in:' . implode(',', array_keys(CalendarioPago::RECURRENTES)),
            'dias_recordatorio' => 'nullable|integer|min:1|max:30',
            'notas_internas' => 'nullable|string|max:2000',
        ]);

        $data = $request->all();
        $data['estado'] = 'pendiente';
        $data['dias_recordatorio'] = $data['dias_recordatorio'] ?? 3;
        $data['recordatorio_enviado'] = false;

        // Si es recurrente, crear pagos futuros según el patrón
        if ($data['recurrente'] !== 'unico') {
            $this->createRecurringPayments($data);
        } else {
            CalendarioPago::create($data);
        }

        return redirect()
            ->route('calendario-pagos.calendario')
            ->with('success', 'Pago programado correctamente.');
    }

    private function createRecurringPayments($data)
    {
        $fechaPago = Carbon::parse($data['fecha_pago']);
        $recurrencia = $data['recurrente'];

        // Crear pagos recurrentes por 2 años
        $maxPagos = $recurrencia === 'mensual' ? 24 :
                     ($recurrencia === 'trimestral' ? 8 :
                     ($recurrencia === 'semestral' ? 4 : 2));

        for ($i = 0; $i < $maxPagos; $i++) {
            $nuevoPago = $data;
            $nuevoPago['fecha_pago'] = $fechaPago->copy();
            // Para los pagos recurrentes, marcarlos como 'unico' para evitar bucles infinitos
            $nuevoPago['recurrente'] = 'unico';

            // Añadir intervalo según la recurrencia
            switch ($recurrencia) {
                case 'mensual':
                    $fechaPago->addMonth(1);
                    break;
                case 'trimestral':
                    $fechaPago->addMonths(3);
                    break;
                case 'semestral':
                    $fechaPago->addMonths(6);
                    break;
                case 'anual':
                    $fechaPago->addYear(1);
                    break;
            }

            CalendarioPago::create($nuevoPago);
        }
    }

    public function show($id)
    {
        $pago = CalendarioPago::with('proveedor')->findOrFail($id);

        return view('calendario-pagos.show', compact('pago'));
    }

    public function edit($id)
    {
        $pago = CalendarioPago::findOrFail($id);
        $proveedores = Proveedor::orderBy('nombre')->get();
        $tiposPago = CalendarioPago::TIPOS_PAGO;
        $categorias = CalendarioPago::CATEGORIAS;
        $recurrentes = CalendarioPago::RECURRENTES;

        return view('calendario-pagos.edit', compact(
            'pago',
            'proveedores',
            'tiposPago',
            'categorias',
            'recurrentes'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo_servicio' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'proveedor_id' => 'required|exists:proveedores,id',
            'monto' => 'required|numeric|min:0|max:999999999.99',
            'fecha_pago' => 'required|date',
            'tipo_pago' => 'required|in:' . implode(',', array_keys(CalendarioPago::TIPOS_PAGO)),
            'categoria' => 'nullable|in:' . implode(',', array_keys(CalendarioPago::CATEGORIAS)),
            'estado' => 'required|in:' . implode(',', array_keys(CalendarioPago::ESTADOS)),
            'dias_recordatorio' => 'nullable|integer|min:1|max:30',
            'notas_internas' => 'nullable|string|max:2000',
        ]);

        $pago = CalendarioPago::findOrFail($id);
        $pago->update($request->all());

        return redirect()
            ->route('calendario-pagos.calendario')
            ->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy($id)
    {
        $pago = CalendarioPago::findOrFail($id);
        $pago->delete();

        return redirect()
            ->route('calendario-pagos.calendario')
            ->with('success', 'Pago eliminado correctamente.');
    }

    // Métodos adicionales

    public function pagosDelDia(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date'
        ]);

        $fecha = Carbon::parse($request->fecha);
        $pagos = CalendarioPago::with('proveedor')
            ->whereDate('fecha_pago', $fecha)
            ->orderBy('fecha_pago', 'asc')
            ->get();

        $stats = [
            'total' => $pagos->count(),
            'pendientes' => $pagos->where('estado', 'pendiente')->count(),
            'pagados' => $pagos->where('estado', 'pagado')->count(),
            'vencidos' => $pagos->where(function($p) {
                return $p->fecha_pago->isPast() && $p->estado !== 'pagado';
            })->count(),
            'monto_total' => $pagos->sum('monto'),
            'monto_pendiente' => $pagos->where('estado', 'pendiente')->sum('monto'),
        ];

        return view('calendario-pagos.dia', compact(
            'fecha',
            'pagos',
            'stats'
        ));
    }

    public function marcarPagado(Request $request, $id)
    {
        $pago = CalendarioPago::findOrFail($id);
        $pago->estado = 'pagado';
        $pago->save();

        return redirect()
            ->route('calendario-pagos.calendario')
            ->with('success', 'Pago marcado como pagado.');
    }

    public function recordatorios(Request $request)
    {
        // Obtener pagos que necesitan recordatorio
        $pagos = CalendarioPago::with('proveedor')
            ->where('estado', 'pendiente')
            ->where('recordatorio_enviado', false)
            ->whereRaw('julianday(fecha_pago) - julianday(current_date) <= dias_recordatorio')
            ->whereRaw('julianday(fecha_pago) >= julianday(current_date)')
            ->orderBy('fecha_pago', 'asc')
            ->get();

        $stats = [
            'total' => $pagos->count(),
            'enviados' => 0
        ];

        foreach ($pagos as $pago) {
            // Aquí podrías enviar email o notificación
            // Por ahora solo marcamos como enviado
            $pago->recordatorio_enviado = true;
            $pago->save();
            $stats['enviados']++;
        }

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    public function dashboard()
    {
        $hoy = now();

        // Estadísticas generales
        $estadisticas = [
            'total' => CalendarioPago::count(),
            'pendientes' => CalendarioPago::pendientes()->count(),
            'pagados' => CalendarioPago::pagados()->count(),
            'vencidos' => CalendarioPago::vencidos()->count(),
            'monto_total' => CalendarioPago::sum('monto'),
            'monto_pendiente' => CalendarioPago::pendientes()->sum('monto'),
        ];

        // Pagos próximos (7 días)
        $proximos = CalendarioPago::with('proveedor')
            ->proximos(7)
            ->orderBy('fecha_pago', 'asc')
            ->limit(10)
            ->get();

        // Pagos vencidos
        $vencidos = CalendarioPago::with('proveedor')
            ->vencidos()
            ->orderBy('fecha_pago', 'desc')
            ->limit(10)
            ->get();

        // Pagos del mes actual
        $pagosMes = CalendarioPago::delMes()
            ->with('proveedor')
            ->orderBy('fecha_pago', 'asc')
            ->get();

        // Estadísticas por categoría
        $porCategoria = CalendarioPago::selectRaw('categoria, COUNT(*) as count, SUM(monto) as total')
            ->whereNotNull('categoria')
            ->groupBy('categoria')
            ->get()
            ->mapWithKeys(function($item) {
                return [
                    'categoria' => $item->categoria,
                    'count' => $item->count,
                    'total' => $item->total,
                    'label' => CalendarioPago::CATEGORIAS[$item->categoria] ?? $item->categoria
                ];
            });

        return view('calendario-pagos.dashboard', compact(
            'estadisticas',
            'proximos',
            'vencidos',
            'pagosMes',
            'porCategoria'
        ));
    }
}
