<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin DEMAR</title>
    <link rel="icon" type="image/png" href="{{ asset('Logo.png') }}">
    <style>
        :root {
            --deep: #09192e;
            --mid: #163352;
            --teal: #287a7a;
            --aqua: #4ecdc4;
            --pearl: #f2ede6;
            --cream: #faf8f4;
            --gold: #c6954e;
            --text: #1e2a35;
            --muted: #6b7a8a;
            --border: rgba(9, 25, 46, 0.12);
            --panel: #ffffff;
            --soft: #f7fbfa;
            --danger: #c0392b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(78, 205, 196, 0.18), transparent 28%),
                linear-gradient(135deg, #fdfbf7 0%, var(--cream) 54%, #e9f7f5 100%);
            overflow-x: hidden;
        }

        .admin-shell {
            display: grid;
            grid-template-columns: 280px minmax(0, 1fr);
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(180deg, var(--deep) 0%, var(--mid) 58%, var(--teal) 100%);
            color: #fff;
            padding: 26px 22px;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 52px;
        }

        .brand-mark {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.22);
            display: grid;
            place-items: center;
            overflow: hidden;
        }

        .brand-mark img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .brand h1 {
            font-size: 1.25rem;
            line-height: 1.1;
            letter-spacing: 0;
        }

        .brand span {
            display: block;
            margin-top: 4px;
            color: rgba(255, 255, 255, 0.68);
            font-size: 0.82rem;
            font-weight: 600;
        }

        .menu {
            display: grid;
            gap: 10px;
        }

        .menu-button {
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.78);
            border-radius: 12px;
            padding: 13px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            font: inherit;
            font-weight: 800;
            text-align: left;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        .menu-button svg {
            width: 20px;
            height: 20px;
            flex: 0 0 auto;
        }

        .menu-button:hover,
        .menu-button.active {
            background: rgba(78, 205, 196, 0.2);
            color: #fff;
            transform: translateX(2px);
        }

        .sidebar-footer {
            margin-top: auto;
            display: grid;
            gap: 12px;
            color: rgba(255, 255, 255, 0.72);
            font-size: 0.88rem;
        }

        .btn-logout {
            border: none;
            border-radius: 12px;
            padding: 12px 16px;
            font: inherit;
            font-weight: 800;
            cursor: pointer;
            background: var(--aqua);
            color: var(--deep);
        }

        .main {
            min-width: 0;
            padding: 26px 30px 34px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            margin-bottom: 24px;
        }

        .kicker {
            color: var(--teal);
            font-size: 0.76rem;
            font-weight: 900;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .topbar h2 {
            color: var(--deep);
            font-size: clamp(1.7rem, 3vw, 2.4rem);
            line-height: 1.05;
            letter-spacing: 0;
        }

        .topbar p {
            margin-top: 8px;
            color: var(--muted);
            line-height: 1.5;
        }

        .admin-badge {
            border: 1px solid var(--border);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.78);
            padding: 10px 14px;
            color: var(--mid);
            font-weight: 800;
            white-space: nowrap;
        }

        .section {
            display: none;
            animation: fadeIn 0.22s ease;
        }

        .section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 18px;
        }

        .stat-card,
        .panel,
        .form-panel {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: 0 14px 38px rgba(9, 25, 46, 0.08);
        }

        .stat-card {
            padding: 18px;
            min-height: 112px;
            display: grid;
            align-content: space-between;
        }

        .stat-card span {
            color: var(--muted);
            font-size: 0.86rem;
            font-weight: 800;
        }

        .stat-card strong {
            color: var(--deep);
            font-size: 1.65rem;
            line-height: 1;
        }

        .stat-card small {
            color: var(--teal);
            font-weight: 800;
        }

        .content-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 340px;
            gap: 18px;
            align-items: start;
        }

        .panel {
            overflow: hidden;
        }

        .panel-header {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
        }

        .panel-header h3 {
            color: var(--deep);
            font-size: 1.12rem;
        }

        .panel-header span {
            color: var(--muted);
            font-size: 0.9rem;
        }

        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 16px 20px;
            background: var(--soft);
            border-bottom: 1px solid rgba(9, 25, 46, 0.07);
        }

        input,
        select,
        textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            color: var(--text);
            font: inherit;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input,
        select {
            height: 44px;
            padding: 0 12px;
        }

        textarea {
            min-height: 94px;
            resize: vertical;
            padding: 12px;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--aqua);
            box-shadow: 0 0 0 4px rgba(78, 205, 196, 0.16);
        }

        .filters input,
        .filters select {
            flex: 1 1 180px;
        }

        .table-wrap {
            overflow: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 720px;
        }

        th,
        td {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(9, 25, 46, 0.07);
            text-align: left;
            vertical-align: middle;
        }

        th {
            color: var(--muted);
            font-size: 0.78rem;
            font-weight: 900;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: #fff;
        }

        td {
            color: var(--text);
            font-size: 0.94rem;
        }

        .money,
        .status-ok {
            color: var(--teal);
            font-weight: 900;
        }

        .status-low {
            color: var(--danger);
            font-weight: 900;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 30px;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(78, 205, 196, 0.14);
            color: var(--teal);
            font-size: 0.82rem;
            font-weight: 900;
        }

        .product-cell {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 220px;
        }

        .product-cell img {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            background: var(--pearl);
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .icon-btn {
            width: 36px;
            height: 36px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            color: var(--mid);
            cursor: pointer;
            display: inline-grid;
            place-items: center;
            transition: color 0.2s ease, border-color 0.2s ease, background 0.2s ease;
        }

        .icon-btn:hover {
            color: var(--teal);
            border-color: rgba(78, 205, 196, 0.55);
            background: rgba(78, 205, 196, 0.08);
        }

        .icon-btn svg {
            width: 18px;
            height: 18px;
        }

        .form-panel {
            padding: 20px;
            display: grid;
            gap: 14px;
        }

        .form-panel h3 {
            color: var(--deep);
            font-size: 1.12rem;
        }

        .field-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .field {
            display: grid;
            gap: 7px;
        }

        label {
            color: var(--mid);
            font-size: 0.82rem;
            font-weight: 900;
        }

        .btn-primary {
            border: none;
            border-radius: 8px;
            min-height: 46px;
            padding: 12px 16px;
            background: linear-gradient(135deg, var(--teal) 0%, var(--aqua) 100%);
            color: #fff;
            font: inherit;
            font-weight: 900;
            cursor: pointer;
            box-shadow: 0 12px 24px rgba(40, 122, 122, 0.2);
        }

        .summary-list {
            display: grid;
            gap: 12px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            border-bottom: 1px solid rgba(9, 25, 46, 0.08);
            padding-bottom: 12px;
        }

        .summary-item:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .summary-item span {
            color: var(--muted);
        }

        .summary-item strong {
            color: var(--deep);
        }

        .report-card {
            display: grid;
            gap: 18px;
        }

        .chart-shell {
            background: linear-gradient(135deg, rgba(78, 205, 196, 0.09), rgba(255, 255, 255, 0.95));
            border: 1px solid rgba(40, 122, 122, 0.16);
            border-radius: 16px;
            padding: 18px;
            overflow-x: auto;
            overflow-y: hidden;
        }

        .chart-shell-inner {
            display: block;
            width: max-content;
        }

        .chart-shell svg {
            width: auto;
            height: auto;
            display: block;
            min-width: 760px;
        }

        .chart-caption {
            margin-top: 10px;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .report-table {
            margin-top: 16px;
            overflow-x: auto;
        }

        .report-table table {
            width: 100%;
            border-collapse: collapse;
            min-width: 540px;
            background: #fff;
        }

        .report-table th,
        .report-table td {
            padding: 12px 14px;
            border-bottom: 1px solid rgba(9, 25, 46, 0.08);
            text-align: left;
            color: var(--text);
            font-size: 0.95rem;
        }

        .report-table th {
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-weight: 900;
            background: rgba(78, 205, 196, 0.08);
        }

        .report-table td.money {
            text-align: right;
            white-space: nowrap;
        }

        .report-table tbody tr:last-child td {
            border-bottom: none;
        }
        }

        .empty-state {
            padding: 24px;
            border: 1px dashed rgba(9, 25, 46, 0.16);
            border-radius: 14px;
            text-align: center;
            color: var(--muted);
            background: rgba(255, 255, 255, 0.72);
        }

        @media print {
            body {
                background: #fff;
            }

            .sidebar,
            .menu-button,
            .btn-primary,
            .filters,
            .topbar,
            .admin-badge {
                display: none !important;
            }

            .admin-shell {
                display: block;
            }

            .main {
                padding: 0;
            }

            .panel,
            .form-panel,
            .stat-card,
            .chart-shell {
                box-shadow: none;
                border: 1px solid #ddd;
            }

            .section {
                display: block !important;
            }
        }

        @media (max-width: 1120px) {
            .admin-shell {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: sticky;
                top: 0;
                z-index: 10;
                padding: 18px;
            }

            .menu {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .sidebar-footer {
                display: none;
            }

            .content-grid,
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 720px) {
            .main {
                padding: 18px 14px 24px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .admin-badge {
                white-space: normal;
            }

            .menu,
            .content-grid,
            .stats-grid,
            .field-grid {
                grid-template-columns: 1fr;
            }
        }

        .form-panel form {
            display: flex;
            flex-direction: column;
            gap: 18px;
            padding: 10px 0;
        }
        .form-panel .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .form-panel .field label {
            font-weight: 600;
            font-size: 14px;
            color: #4a5568;
        }
        .form-panel .btn-crear-cajero {
            margin-top: 12px;
            align-self: center;
            padding: 10px 30px;
            cursor: pointer;
            width: auto;
            min-width: 160px;
        }

        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }
        .password-container input {
            width: 100%;
            padding-right: 40px; 
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #718096;
            transition: color 0.2s;
        }
        .toggle-password:hover {
            color: #4a5568;
        }

        
        .btn-action {
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .btn-edit { color: #1F556c; }
        .btn-edit:hover { background-color: #e2f1f5; color: #17a2b8; }
        .btn-delete { color: #e57373; }
        .btn-delete:hover { background-color: #fff5f5; color: #c53030; }
        .btn-action svg { width: 18px; height: 18px; fill: currentColor; }

        /* Estilos del modal emergente */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0; pointer-events: none;
            transition: opacity 0.2s ease;
        }
        .modal-overlay.active { opacity: 1; pointer-events: auto; }
        .modal-content {
            background: white;
            padding: 25px;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .modal-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;
        }
        .modal-close { background: none; border: none; font-size: 24px; cursor: pointer; color: #a0aec0; line-height: 1; }
        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
        /* Oculta por completo el ojo nativo que los navegadores meten a la fuerza */
        input::-ms-reveal,
        input::-ms-clear {
            display: none !important;
        }
        input::-webkit-credentials-reveal {
            display: none !important;
        }
    </style>
</head>
<body>
<div class="admin-shell">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-mark">
                <img src="{{ asset('Logo.png') }}" alt="DEMAR">
            </div>
            <div>
                <h1>DEMAR</h1>
                <span>Panel de administrador</span>
            </div>
        </div>

        <nav class="menu" aria-label="Menu de administrador">
            <button class="menu-button active" type="button" data-target="reportes" title="Reportes">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M4 19V5"></path><path d="M4 19h16"></path><path d="M8 16v-5"></path><path d="M12 16V8"></path><path d="M16 16v-7"></path>
                </svg>
                <span>Reportes</span>
            </button>
            <button class="menu-button" type="button" data-target="productos" title="Productos">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M6 3h12l2 5H4l2-5Z"></path><path d="M4 8h16v13H4z"></path><path d="M9 12h6"></path>
                </svg>
                <span>Productos</span>
            </button>
            <button class="menu-button" type="button" data-target="cajeros" title="Cajeros">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M19 8v6"></path><path d="M22 11h-6"></path>
                </svg>
                <span>Cajeros</span>
            </button>
        </nav>

        <div class="sidebar-footer">
            <span>Solo personal autorizado.</span>
            <form method="POST" action="{{ route('cajero.logout.post') }}">
                @csrf
                <button class="btn-logout" type="submit">Cerrar sesi&oacute;n</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <div class="kicker">Acceso autorizado</div>
                <h2>Panel de administrador</h2>
                <p>Gestiona ventas, productos y usuarios cajeros desde un solo lugar.</p>
            </div>
            <div class="admin-badge">Administrador</div>
        </header>

        <section class="section active" id="reportes" aria-label="Reportes de ventas">
            <div class="stats-grid">
                @php
                    $ventasHoyTotal = $ventasHoyTotal ?? 0;
                    $ventasMesTotal = $ventasMesTotal ?? 0;
                    $ticketPromedio = $ticketPromedio ?? 0;
                    $unidadesVendidas = $unidadesVendidas ?? 0;
                    $ventas = $ventas ?? collect();
                @endphp
                <article class="stat-card">
                    <span>Ventas de hoy</span>
                    <strong>S/ {{ number_format((float) $ventasHoyTotal, 2, ',', '.') }}</strong>
                    <small>{{ $ventas->filter(function ($venta) { return $venta->created_at && $venta->created_at->between(today()->startOfDay(), today()->endOfDay()); })->count() }} operaciones</small>
                </article>
                <article class="stat-card">
                    <span>Ventas del mes</span>
                    <strong>S/ {{ number_format((float) $ventasMesTotal, 2, ',', '.') }}</strong>
                    <small>{{ $ventas->filter(function ($venta) { return $venta->created_at && $venta->created_at->month === now()->month && $venta->created_at->year === now()->year; })->count() }} comprobantes</small>
                </article>
                <article class="stat-card">
                    <span>Ticket promedio</span>
                    <strong>S/ {{ number_format((float) $ticketPromedio, 2, ',', '.') }}</strong>
                    <small>Según historial</small>
                </article>
                <article class="stat-card">
                    <span>Productos vendidos</span>
                    <strong>{{ (int) $unidadesVendidas }}</strong>
                    <small>Unidades</small>
                </article>
            </div>

            <div class="content-grid">
                <article class="panel report-card">
                    <div class="panel-header">
                        <div>
                            <h3>Ventas por producto</h3>
                            <span>Gráfico de barras con cantidad vendida y precio</span>
                        </div>
                        <button id="exportReportPdf" class="btn-primary" type="button">Exportar PDF</button>
                    </div>

                    @php $productosReporte = $productosReporte ?? collect(); @endphp
                    @if($productosReporte->isEmpty())
                        <div class="empty-state">Aún no hay ventas registradas para mostrar un gráfico.</div>
                    @else
                        @php
                            $maxCantidad = max($productosReporte->pluck('cantidad')->toArray());
                            $maxPrecio = max($productosReporte->pluck('precio')->toArray());
                            $maxPrecio = $maxPrecio > 0 ? $maxPrecio : 1;
                            $maxCantidad = $maxCantidad > 0 ? $maxCantidad : 1;
                            $chartProducts = $productosReporte->count();
                            $chartWidth = max(760, 95 + ($chartProducts * 120) + 80);
                            $xAxisEnd = $chartWidth - 70;
                        @endphp
                        <div class="chart-shell">
                            <div class="chart-shell-inner">
                                <svg viewBox="0 0 {{ $chartWidth }} 340" role="img" aria-label="Gráfico de barras por producto" style="min-width: {{ $chartWidth }}px;">
                                    <line x1="70" y1="285" x2="{{ $xAxisEnd }}" y2="285" stroke="#163352" stroke-width="2"></line>
                                    <line x1="70" y1="40" x2="70" y2="285" stroke="#163352" stroke-width="2"></line>

                                    @for ($tick = 0; $tick <= 4; $tick++)
                                        @php $priceValue = round(($maxPrecio / 4) * $tick, 2); $yPos = 285 - ($tick * 55); @endphp
                                        <line x1="70" y1="{{ $yPos }}" x2="{{ $xAxisEnd }}" y2="{{ $yPos }}" stroke="#dfe7e7" stroke-dasharray="4 4"></line>
                                        <text x="40" y="{{ $yPos + 4 }}" font-size="11" fill="#6b7a8a" text-anchor="end">S/ {{ number_format($priceValue, 2, ',', '.') }}</text>
                                    @endfor

                                    <text x="70" y="305" font-size="11" fill="#6b7a8a" text-anchor="middle">0</text>
                                    <text x="{{ $xAxisEnd }}" y="305" font-size="11" fill="#6b7a8a" text-anchor="end">{{ $maxCantidad }}</text>

                                    @foreach($productosReporte as $index => $producto)
                                        @php
                                            $barWidth = 70;
                                            $barHeight = 25 + (($producto['precio'] / $maxPrecio) * 180);
                                            $x = 95 + ($index * 120);
                                            $y = 285 - $barHeight;
                                        @endphp
                                        <rect x="{{ $x }}" y="{{ $y }}" width="{{ $barWidth }}" height="{{ $barHeight }}" rx="10" fill="#4ecdc4"></rect>
                                        <text x="{{ $x + ($barWidth / 2) }}" y="{{ $y - 8 }}" font-size="12" fill="#163352" text-anchor="middle">{{ Illuminate\Support\Str::limit($producto['nombre'], 14) }}</text>
                                        <text x="{{ $x + ($barWidth / 2) }}" y="300" font-size="11" fill="#6b7a8a" text-anchor="middle">Cant. {{ $producto['cantidad'] }}</text>
                                    @endforeach
                                </svg>
                            </div>
                            <div class="chart-caption">Eje X: cantidad vendida • Eje Y: precio unitario de venta. Desplaza horizontalmente para ver todos los productos.</div>
                        </div>

                        <div class="table-wrap report-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Total vendido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productosReporte as $producto)
                                        <tr>
                                            <td><strong>{{ $producto['nombre'] }}</strong></td>
                                            <td>{{ $producto['cantidad'] }}</td>
                                            <td class="money">S/ {{ number_format($producto['precio'], 2, ',', '.') }}</td>
                                            <td class="money">S/ {{ number_format($producto['total'], 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </article>

                <aside class="form-panel">
                    <h3>Resumen de reportes</h3>
                    <div class="summary-list">
                        <div class="summary-item">
                            <span>Ventas totales</span>
                            <strong>S/ {{ number_format((float) ($ventasMesTotal ?? 0), 2, ',', '.') }}</strong>
                        </div>
                        <div class="summary-item">
                            <span>Ticket promedio</span>
                            <strong>S/ {{ number_format((float) ($ticketPromedio ?? 0), 2, ',', '.') }}</strong>
                        </div>
                        <div class="summary-item">
                            <span>Productos vendidos</span>
                            <strong>{{ (int) ($unidadesVendidas ?? 0) }}</strong>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <section class="section" id="productos" aria-label="CRUD productos">
            <div class="content-grid">
                <article class="panel">
                    <div class="panel-header">
                        <div>
                            <h3>Productos</h3>
                            <span>CRUD productos</span>
                        </div>
                        <span class="pill">Inventario</span>
                    </div>
                    <div class="filters">
                        <input id="buscarProductoAdmin" type="search" placeholder="Buscar producto">
                        <select id="filtrarCategoriaAdmin">
                            <option value="all">Todas las categorias</option>
                            <option value="collar">Collares</option>
                            <option value="pulsera">Pulseras</option>
                        </select>
                    </div>
                    <div class="table-wrap">
                        <table id="tablaProductosAdmin">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Categoria</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productos as $producto)
                                    <tr class="producto-admin-row"
                                        data-nombre="{{ Illuminate\Support\Str::lower($producto->nombre) }}"
                                        data-categoria="{{ Illuminate\Support\Str::lower($producto->categoria ?? '') }}">
                                        <td>
                                            <div class="product-cell">
                                                <img src="{{ asset($producto->imagen ?? 'Logo.png') }}" alt="{{ $producto->nombre }}">
                                                <strong>{{ $producto->nombre }}</strong>
                                            </div>
                                        </td>
                                        <td>{{ ucfirst($producto->categoria) }}</td>
                                        <td class="money">S/ {{ number_format($producto->precio, 2) }}</td>
                                        <td><span class="status-ok">{{ $producto->stock }}</span></td>
                                        <td>
                                            <div class="actions">
                                                <button class="icon-btn" type="button" title="Editar"
                                                    onclick='cargarEdicionProducto(@json($producto))'>
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                        <path d="M12 20h9"></path><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z"></path>
                                                    </svg>
                                                </button>
                                                <form action="{{ route('productos.destroy', $producto) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?');" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="icon-btn" type="submit" title="Eliminar">
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                            <path d="M3 6h18"></path><path d="M8 6V4h8v2"></path><path d="M19 6l-1 14H6L5 6"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5">Aún no hay productos registrados.</td></tr>
                                @endforelse
                                <tr id="productosAdminSinResultados" style="display: none;">
                                    <td colspan="5">No se encontraron productos con ese filtro.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </article>

                <aside class="form-panel">
                    <h3 id="productoFormTitulo">Agregar producto</h3>
                    <form id="formProducto" action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="productoMethod" value="POST">

                        <div class="field">
                            <label for="producto_nombre">Nombre</label>
                            <input id="producto_nombre" name="nombre" type="text" placeholder="Nombre del producto" required>
                        </div>
                        <div class="field">
                            <label for="producto_descripcion">Descripcion</label>
                            <textarea id="producto_descripcion" name="descripcion" placeholder="Descripcion del producto"></textarea>
                        </div>
                        <div class="field-grid">
                            <div class="field">
                                <label for="producto_precio">Precio</label>
                                <input id="producto_precio" name="precio" type="number" min="0" step="0.01" placeholder="0.00" required>
                            </div>
                            <div class="field">
                                <label for="producto_stock">Stock</label>
                                <input id="producto_stock" name="stock" type="number" min="0" placeholder="0" required>
                            </div>
                        </div>
                        <div class="field">
                            <label for="producto_categoria">Categoria</label>
                            <select id="producto_categoria" name="categoria">
                                <option value="collar">Collar</option>
                                <option value="pulsera">Pulsera</option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="producto_imagen">Imagen</label>
                            <input id="producto_imagen" name="imagen" type="file" accept="image/*">
                        </div>
                        <button class="btn-primary" type="submit">Guardar producto</button>
                        <button class="btn-secondary" type="button" id="cancelarEdicionProducto" style="display:none;margin-top:8px;">Cancelar edición</button>
                    </form>
                </aside>
            </div>
        </section>

       <section class="section" id="cajeros" aria-label="Gestión de cajeros">
            <div class="content-grid">
                        
                    <article class="panel">
                        <div class="panel-header">
                            <div>
                                <h3>Cajeros</h3>
                                <span>Agregar o crear nuevos usuarios cajeros</span>
                            </div>
                            <span class="pill">Usuarios</span>
                        </div>
                        <div class="table-wrap">
                            <table id="tabla-cajeros">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Rol</th>
                                        <th style="text-align: center; width: 100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usuarios ?? [] as $usuario)
                                        <tr>
                                            <td>{{ $usuario->nombre ?? $usuario->name }}</td>
                                            <td>{{ $usuario->email }}</td>
                                            <td>{{ ucfirst($usuario->rol) }}</td>
                                            <td style="text-align: center; display: flex; justify-content: center; gap: 6px;">
                                                
                                                <button class="btn-action btn-edit" title="Editar"
                                                        data-id="{{ $usuario->id }}"
                                                        data-nombre="{{ $usuario->nombre ?? $usuario->name }}"
                                                        data-email="{{ $usuario->email }}">
                                                    <svg viewBox="0 0 24 24">
                                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                    </svg>
                                                </button>
                                                
                                                <form action="{{ route('cajeros.destroy', $usuario->id ?? $usuario->name) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar a este cajero?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-action btn-delete" title="Eliminar">
                                                        <svg viewBox="0 0 24 24">
                                                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                    @if(empty($usuarios) || count($usuarios) == 0)
                                        <tr class="row-vacia">
                                            <td colspan="4" style="text-align: center; color: #a0aec0; padding: 20px;">
                                                No hay cajeros registrados todavía.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </article>

                    <aside class="form-panel">
                        <h3>Nuevo cajero</h3>
                        
                        @if(session('success'))
                            <div style="color: #2f855a; background-color: #f0fff4; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(isset($errors) && $errors->any())
                            <div style="color: #c53030; background-color: #fff5f5; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                                <ul style="margin: 0; padding-left: 20px;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form id="form-crear-cajero" method="POST" action="{{ route('cajeros.store') }}">
                            @csrf
                            <div class="field">
                                <label for="cajero_nombre">Nombre</label>
                                <input id="cajero_nombre" name="nombre" type="text" placeholder="Nombre del cajero" value="{{ old('nombre') }}" required>
                            </div>
                            <div class="field">
                                <label for="cajero_email">Correo</label>
                                <input id="cajero_email" name="email" type="email" placeholder="cajero@demar.com" value="{{ old('email') }}" required>
                            </div>
                            <div class="field">
                                <label for="cajero_password">Contraseña</label>
                                <div class="password-container">
                                    <input id="cajero_password" name="password" type="password" placeholder="Mínimo 6 caracteres" required>
                                    <button type="button" class="toggle-password" data-target="cajero_password">
                                        <svg style="width:20px;height:20px;" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <button class="btn-primary btn-crear-cajero" type="submit">Crear cajero</button>
                        </form>
                    </aside>

                </div>

                <div class="modal-overlay" id="modal-editar-cajero">
                    <div class="modal-content form-panel">
                        <div class="modal-header">
                            <h3>Editar Cajero</h3>
                            <button class="modal-close" id="btn-close-modal">&times;</button>
                        </div>
                        <form id="form-editar-cajero" method="POST" action="">
                            @csrf
                            @method('PUT')
                            
                            <div class="field">
                                <label for="edit_nombre">Nombre</label>
                                <input id="edit_nombre" name="nombre" type="text" required>
                            </div>
                            
                            <div class="field">
                                <label for="edit_email">Correo</label>
                                <input id="edit_email" name="email" type="email" required>
                            </div>
                            
                            <div class="field">
                                <label for="edit_password">Contraseña (Dejar en blanco para no cambiar)</label>
                                <div class="password-container">
                                    <input id="edit_password" name="password" type="password" placeholder="Mínimo 6 caracteres">
                                    <button type="button" class="toggle-password" data-target="edit_password">
                                        <svg style="width:20px;height:20px;" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn-secondary" id="btn-cancel-modal" style="padding: 10px 20px; background: #e2e8f0; border: none; border-radius: 4px; cursor: pointer;">Cancelar</button>
                                <button type="submit" class="btn-primary" style="padding: 10px 20px; cursor: pointer;">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
        </section> 
   </main>
</div>

<script>
    const menuButtons = document.querySelectorAll('.menu-button');
    const sections = document.querySelectorAll('.section');

    menuButtons.forEach(button => {
        button.addEventListener('click', () => {
            const target = button.dataset.target;

            menuButtons.forEach(item => item.classList.remove('active'));
            sections.forEach(section => section.classList.remove('active'));

            button.classList.add('active');
            document.getElementById(target)?.classList.add('active');
        });
    });

    function cargarEdicionProducto(producto) {
        const form = document.getElementById('formProducto');
        form.action = `/admin/productos/${producto.id}`;
        document.getElementById('productoMethod').value = 'PUT';
        document.getElementById('productoFormTitulo').textContent = 'Editar producto';
        document.getElementById('producto_nombre').value = producto.nombre;
        document.getElementById('producto_descripcion').value = producto.descripcion ?? '';
        document.getElementById('producto_precio').value = producto.precio;
        document.getElementById('producto_stock').value = producto.stock;
        document.getElementById('producto_categoria').value = producto.categoria;
        document.getElementById('cancelarEdicionProducto').style.display = 'inline-block';
    }

    document.getElementById('cancelarEdicionProducto')?.addEventListener('click', () => {
        const form = document.getElementById('formProducto');
        form.action = "{{ route('productos.store') }}";
        document.getElementById('productoMethod').value = 'POST';
        document.getElementById('productoFormTitulo').textContent = 'Agregar producto';
        form.reset();
        document.getElementById('cancelarEdicionProducto').style.display = 'none';
    });

    function cargarEdicionCajero(id, nombre, email) {
        const form = document.getElementById('formCajero');
        form.action = `/admin/cajeros/${id}`;
        document.getElementById('cajeroMethod').value = 'PUT';
        document.getElementById('cajeroFormTitulo').textContent = 'Editar cajero';
        document.getElementById('cajero_nombre').value = nombre;
        document.getElementById('cajero_email').value = email;
        document.getElementById('cajero_password').placeholder = 'Dejar en blanco para no cambiarla';
        document.getElementById('cancelarEdicionCajero').style.display = 'inline-block';
    }

    document.getElementById('cancelarEdicionCajero')?.addEventListener('click', () => {
        const form = document.getElementById('formCajero');
        form.action = "{{ route('cajeros.store') }}";
        document.getElementById('cajeroMethod').value = 'POST';
        document.getElementById('cajeroFormTitulo').textContent = 'Nuevo cajero';
        form.reset();
        document.getElementById('cancelarEdicionCajero').style.display = 'none';
    });
   document.addEventListener('DOMContentLoaded', function() {
    const iconoOjoAbierto = `<svg style="width:20px;height:20px;" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>`;
    const iconoOjoCerrado = `<svg style="width:20px;height:20px;" viewBox="0 0 24 24" fill="currentColor"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.82l2.92 2.92c1.51-1.26 2.7-2.89 3.44-4.74-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.43-1.47.68-2.33.68-2.76 0-5-2.24-5-5 0-.86.25-1.66.68-2.33zM11.84 8.5l2.6 2.6c-.05-.2-.14-.39-.28-.53-.14-.14-.33-.23-.53-.28L11.84 8.5z"/></svg>`;

    const buscarProductoAdmin = document.getElementById('buscarProductoAdmin');
    const filtrarCategoriaAdmin = document.getElementById('filtrarCategoriaAdmin');
    const productosAdminRows = document.querySelectorAll('.producto-admin-row');
    const productosAdminSinResultados = document.getElementById('productosAdminSinResultados');

    function filtrarProductosAdmin() {
        const busqueda = (buscarProductoAdmin?.value || '').trim().toLowerCase();
        const categoria = filtrarCategoriaAdmin?.value || 'all';
        let visibles = 0;

        productosAdminRows.forEach(row => {
            const nombre = row.dataset.nombre || '';
            const categoriaProducto = row.dataset.categoria || '';
            const coincideBusqueda = nombre.includes(busqueda);
            const coincideCategoria = categoria === 'all' || categoriaProducto === categoria;
            const mostrar = coincideBusqueda && coincideCategoria;

            row.style.display = mostrar ? '' : 'none';
            if (mostrar) {
                visibles++;
            }
        });

        if (productosAdminSinResultados) {
            productosAdminSinResultados.style.display = visibles === 0 && productosAdminRows.length > 0 ? '' : 'none';
        }
    }

    buscarProductoAdmin?.addEventListener('input', filtrarProductosAdmin);
    filtrarCategoriaAdmin?.addEventListener('change', filtrarProductosAdmin);
    filtrarProductosAdmin();

    
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.innerHTML = iconoOjoCerrado;
        
        button.addEventListener('click', function() {
            const targetId = this.dataset.target;
            const input = document.getElementById(targetId);
            
            if (input.type === 'password') {
                input.type = 'text';
                this.innerHTML = iconoOjoAbierto; 
                this.style.color = '#17a2b8';     
            } else {
                input.type = 'password';
                this.innerHTML = iconoOjoCerrado; 
                this.style.color = '#718096';      
            }
        });
    });

    @php
        $pdfReportRows = $productosReporte->map(function ($producto) {
            return [
                'nombre' => $producto['nombre'],
                'cantidad' => $producto['cantidad'],
                'precio' => number_format($producto['precio'], 2, ',', '.'),
                'total' => number_format($producto['total'], 2, ',', '.'),
            ];
        })->values();
    @endphp

    const pdfReportRows = @json($pdfReportRows);

    async function loadScript(src) {
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = src;
            script.onload = () => resolve();
            script.onerror = () => reject(new Error(`No se pudo cargar ${src}`));
            document.body.appendChild(script);
        });
    }

    async function ensurePdfLibraries() {
        if (!window.jspdf) {
            await loadScript('https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js');
        }

        const jsPDFClass = window.jspdf?.jsPDF || window.jspdf;
        if (!jsPDFClass) {
            throw new Error('No se cargó correctamente la librería jsPDF.');
        }

        return jsPDFClass;
    }

    document.getElementById('exportReportPdf')?.addEventListener('click', async () => {
        const button = document.getElementById('exportReportPdf');
        button.disabled = true;
        button.textContent = 'Generando PDF...';

        try {
            const jsPDFClass = await ensurePdfLibraries();
            const doc = new jsPDFClass('portrait', 'pt', 'a4');
            const pageWidth = doc.internal.pageSize.getWidth();
            const margin = 40;
            const title = 'Reportes de ventas por productos de la tienda Demar';
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(16);
            doc.text(title, margin, 50);

            const headers = ['Producto', 'Cantidad', 'Precio', 'Total vendido'];
            const columnWidths = [240, 80, 100, 120];
            let y = 80;
            doc.setFontSize(12);
            doc.setFont('helvetica', 'bold');

            let x = margin;
            headers.forEach((header, index) => {
                doc.text(header, x + 2, y);
                x += columnWidths[index];
            });

            doc.setDrawColor(200);
            doc.setLineWidth(0.5);
            doc.line(margin, y + 4, margin + columnWidths.reduce((sum, width) => sum + width, 0), y + 4);
            y += 18;
            doc.setFont('helvetica', 'normal');

            pdfReportRows.forEach((row) => {
                if (y + 30 > doc.internal.pageSize.getHeight() - margin) {
                    doc.addPage();
                    y = margin;
                }

                const nameLines = doc.splitTextToSize(row.nombre, columnWidths[0] - 8);
                const rowHeight = Math.max(14, nameLines.length * 14);

                x = margin;
                doc.text(nameLines, x + 2, y + rowHeight - 4);
                x += columnWidths[0];
                doc.text(String(row.cantidad), x + 2, y + rowHeight - 4);
                x += columnWidths[1];
                doc.text(`S/ ${row.precio}`, x + 2, y + rowHeight - 4);
                x += columnWidths[2];
                doc.text(`S/ ${row.total}`, x + 2, y + rowHeight - 4);

                y += rowHeight + 8;
            });

            doc.save('reporte-productos.pdf');
        } catch (error) {
            console.error(error);
            alert('Ocurrió un error al crear el PDF. Intenta de nuevo.');
        } finally {
            button.disabled = false;
            button.textContent = 'Exportar PDF';
        }
    });

    // 2. LÓGICA DE CONTROL DEL MODAL (EDITAR)
    const modal = document.getElementById('modal-editar-cajero');
    const formEditar = document.getElementById('form-editar-cajero');
    const btnClose = document.getElementById('btn-close-modal');
    const btnCancel = document.getElementById('btn-cancel-modal');
    
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const nombre = this.dataset.nombre;
            const email = this.dataset.email;
            
            formEditar.setAttribute('action', `/admin/cajeros/${id}`);
            
            document.getElementById('edit_nombre').value = nombre;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_password').value = ''; 
            
            // Forzar a que empiece en tipo password y con el icono tachado al abrir
            const editPassInput = document.getElementById('edit_password');
            editPassInput.type = 'password';
            
            const editBtn = document.querySelector('[data-target="edit_password"]');
            editBtn.innerHTML = iconoOjoCerrado;
            editBtn.style.color = '#718096';
            
            modal.classList.add('active');
        });
    });
    
    const cerrarModal = () => modal.classList.remove('active');
    btnClose.addEventListener('click', cerrarModal);
    btnCancel.addEventListener('click', cerrarModal);
    modal.addEventListener('click', (e) => { if(e.target === modal) cerrarModal(); });
});
</script>
</body>
</html>
