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
        }

        .chart-shell svg {
            width: 100%;
            height: auto;
            display: block;
        }

        .chart-caption {
            margin-top: 10px;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .report-table {
            margin-top: 16px;
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
                        <button class="btn-primary" type="button" onclick="window.print()">Exportar PDF</button>
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
                        @endphp
                        <div class="chart-shell">
                            <svg viewBox="0 0 760 340" role="img" aria-label="Gráfico de barras por producto">
                                <line x1="70" y1="285" x2="690" y2="285" stroke="#163352" stroke-width="2"></line>
                                <line x1="70" y1="40" x2="70" y2="285" stroke="#163352" stroke-width="2"></line>

                                @for ($tick = 0; $tick <= 4; $tick++)
                                    @php $priceValue = round(($maxPrecio / 4) * $tick, 2); @endphp
                                    <line x1="70" y1="{{ 285 - ($tick * 55) }}" x2="690" y2="{{ 285 - ($tick * 55) }}" stroke="#dfe7e7" stroke-dasharray="4 4"></line>
                                    <text x="40" y="{{ 289 - ($tick * 55) }}" font-size="11" fill="#6b7a8a" text-anchor="end">S/ {{ number_format($priceValue, 2, ',', '.') }}</text>
                                @endfor

                                @for ($tick = 0; $tick <= 4; $tick++)
                                    @php $qtyValue = round(($maxCantidad / 4) * $tick, 0); @endphp
                                    <text x="{{ 70 + ($tick * 155) }}" y="305" font-size="11" fill="#6b7a8a" text-anchor="middle">{{ $qtyValue }}</text>
                                @endfor

                                @foreach($productosReporte as $index => $producto)
                                    @php
                                        $barWidth = 24 + (($producto['cantidad'] / $maxCantidad) * 90);
                                        $barHeight = 25 + (($producto['precio'] / $maxPrecio) * 180);
                                        $x = 95 + ($index * 110);
                                        $y = 285 - $barHeight;
                                    @endphp
                                    <rect x="{{ $x }}" y="{{ $y }}" width="70" height="{{ $barHeight }}" rx="10" fill="#4ecdc4"></rect>
                                    <text x="{{ $x + 35 }}" y="{{ $y - 8 }}" font-size="12" fill="#163352" text-anchor="middle">{{ 
                                        Illuminate\Support\Str::limit($producto['nombre'], 12) }}</text>
                                    <text x="{{ $x + 35 }}" y="{{ 300 }}" font-size="11" fill="#6b7a8a" text-anchor="middle">Cant. {{ $producto['cantidad'] }}</text>
                                @endforeach
                            </svg>
                            <div class="chart-caption">Eje X: cantidad vendida • Eje Y: precio unitario de venta.</div>
                        </div>

                        <div class="table-wrap report-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Total</th>
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
                        <input type="search" placeholder="Buscar producto">
                        <select>
                            <option>Todas las categorias</option>
                            <option>Collares</option>
                            <option>Pulseras</option>
                        </select>
                    </div>
                    <div class="table-wrap">
                        <table>
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
                                    <tr>
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

        <section class="section" id="cajeros" aria-label="Crear cajeros">
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
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cajeros as $cajero)
                                    <tr>
                                        <td>{{ $cajero->nombre }}</td>
                                        <td>{{ $cajero->email }}</td>
                                        <td>Cajero</td>
                                        <td><span class="pill">Activo</span></td>
                                        <td>
                                            <div class="actions">
                                                <button class="icon-btn" type="button" title="Editar"
                                                    onclick="cargarEdicionCajero({{ $cajero->id }}, '{{ addslashes($cajero->nombre) }}', '{{ addslashes($cajero->email) }}')">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                        <path d="M12 20h9"></path><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z"></path>
                                                    </svg>
                                                </button>
                                                <form action="{{ route('cajeros.destroy', $cajero) }}" method="POST" onsubmit="return confirm('¿Eliminar este cajero?');" style="display:inline">
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
                                    <tr><td colspan="5">Aún no hay cajeros registrados.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </article>

                <aside class="form-panel">
                    <h3 id="cajeroFormTitulo">Nuevo cajero</h3>
                    <form id="formCajero" action="{{ route('cajeros.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="cajeroMethod" value="POST">

                        <div class="field">
                            <label for="cajero_nombre">Nombre</label>
                            <input id="cajero_nombre" name="nombre" type="text" placeholder="Nombre del cajero" required>
                        </div>
                        <div class="field">
                            <label for="cajero_email">Correo</label>
                            <input id="cajero_email" name="email" type="email" placeholder="cajero@demar.com" required>
                        </div>
                        <div class="field">
                            <label for="cajero_password">Contrasena</label>
                            <input id="cajero_password" name="password" type="password" placeholder="Contrasena temporal">
                        </div>
                        <button class="btn-primary" type="submit">Crear cajero</button>
                        <button class="btn-secondary" type="button" id="cancelarEdicionCajero" style="display:none;margin-top:8px;">Cancelar edición</button>
                    </form>
                </aside>
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
</script>
</body>
</html>
