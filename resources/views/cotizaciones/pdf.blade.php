<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización {{ $cotizacion->codigo }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo {
            text-align: center;
        }

        .logo h1 {
            margin: 0;
            color: #1e3a8a;
            font-size: 24px;
        }

        .logo p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 14px;
        }

        .quote-info {
            text-align: right;
        }

        .quote-info h2 {
            margin: 0;
            color: #1e3a8a;
            font-size: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .client-info h3, .quote-details h3 {
            margin: 0 0 10px 0;
            color: #1e3a8a;
            font-size: 16px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }

        .info-item {
            margin-bottom: 8px;
        }

        .info-item strong {
            display: inline-block;
            width: 80px;
            color: #333;
        }

        .description {
            margin-bottom: 30px;
        }

        .description h3 {
            margin: 0 0 15px 0;
            color: #1e3a8a;
            font-size: 16px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }

        .description-content {
            white-space: pre-wrap;
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #e5e7eb;
        }

        .conditions {
            margin-bottom: 30px;
        }

        .conditions h3 {
            margin: 0 0 15px 0;
            color: #1e3a8a;
            font-size: 16px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }

        .conditions-content {
            white-space: pre-wrap;
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #e5e7eb;
        }

        .total-section {
            text-align: right;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #1e3a8a;
        }

        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 11px;
            color: #666;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .status-pendiente {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-aprobada {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-rechazada {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-vencida {
            background-color: #f3f4f6;
            color: #374151;
        }

        .validity-info {
            background-color: #eff6ff;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #dbeafe;
            margin-bottom: 20px;
        }

        .validity-info strong {
            color: #1e3a8a;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <h1>ERP Sistema</h1>
            <p>Panel de Administración</p>
        </div>
        <div class="quote-info">
            <h2>COTIZACIÓN</h2>
            <h2>{{ $cotizacion->codigo }}</h2>
            <span class="status-badge status-{{ $cotizacion->estado }}">
                {{ ucfirst($cotizacion->estado) }}
            </span>
        </div>
    </div>

    <!-- Información Principal -->
    <div class="info-grid">
        <div class="client-info">
            <h3>Información del Cliente</h3>
            <div class="info-item">
                <strong>Nombre:</strong> {{ $cotizacion->cliente->nombre }}
            </div>
            @if($cotizacion->cliente->email)
            <div class="info-item">
                <strong>Email:</strong> {{ $cotizacion->cliente->email }}
            </div>
            @endif
            @if($cotizacion->cliente->telefono)
            <div class="info-item">
                <strong>Teléfono:</strong> {{ $cotizacion->cliente->telefono }}
            </div>
            @endif
            @if($cotizacion->cliente->direccion)
            <div class="info-item">
                <strong>Dirección:</strong> {{ $cotizacion->cliente->direccion }}
            </div>
            @endif
        </div>

        <div class="quote-details">
            <h3>Detalles de la Cotización</h3>
            <div class="info-item">
                <strong>Fecha:</strong> {{ $cotizacion->created_at->format('d/m/Y') }}
            </div>
            <div class="info-item">
                <strong>Asunto:</strong> {{ $cotizacion->asunto }}
            </div>
            <div class="info-item">
                <strong>Vigencia:</strong> {{ $cotizacion->vigencia->format('d/m/Y') }}
            </div>
            <div class="info-item">
                <strong>Creada por:</strong> {{ $cotizacion->user->name }}
            </div>
        </div>
    </div>

    <!-- Vigencia -->
    <div class="validity-info">
        <strong>⏰ Vigencia:</strong> Esta cotización es válida hasta el {{ $cotizacion->vigencia->format('d/m/Y') }}.
        @if($cotizacion->vigencia->isPast())
            <br><strong style="color: #dc2626;">⚠️ ATENCIÓN: Esta cotización ha vencido.</strong>
        @else
            <br>Quedan {{ $cotizacion->vigencia->diffInDays(now()) }} días de vigencia.
        @endif
    </div>

    <!-- Descripción -->
    <div class="description">
        <h3>Descripción del Proyecto</h3>
        <div class="description-content">{{ $cotizacion->descripcion }}</div>
    </div>

    <!-- Condiciones (si existen) -->
    @if($cotizacion->condiciones)
    <div class="conditions">
        <h3>Condiciones Comerciales</h3>
        <div class="conditions-content">{{ $cotizacion->condiciones }}</div>
    </div>
    @endif

    <!-- Total -->
    <div class="total-section">
        <div>Monto Total</div>
        <div class="total-amount">${{ number_format($cotizacion->monto, 2, ',', '.') }}</div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Este documento es una cotización generada automáticamente.</p>
        <p>Para cualquier consulta, contactar a {{ $cotizacion->user->email }} | Generado el {{ now()->format('d/m/Y H:i') }}</p>
        <p>Código de referencia: {{ $cotizacion->codigo }}</p>
    </div>
</body>
</html>