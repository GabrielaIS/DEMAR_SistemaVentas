<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja DEMAR</title>
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
            --danger: #c0392b;
            --success: #166534;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(78, 205, 196, 0.16), transparent 28%),
                linear-gradient(135deg, #fdfbf7 0%, var(--cream) 56%, #e9f7f5 100%);
            overflow-x: hidden;
        }

        .shell {
            min-height: 100vh;
        }

        .topbar {
            background: linear-gradient(135deg, var(--deep) 0%, var(--mid) 58%, var(--teal) 100%);
            color: #fff;
            padding: 22px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand img {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            object-fit: cover;
            border: 1px solid rgba(255, 255, 255, 0.22);
            background: rgba(255, 255, 255, 0.14);
        }

        .brand h1 {
            font-size: 1.75rem;
            line-height: 1.05;
            letter-spacing: 0;
        }

        .brand span {
            display: block;
            margin-top: 4px;
            color: rgba(255, 255, 255, 0.72);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .btn-logout {
            border: none;
            border-radius: 10px;
            padding: 11px 18px;
            font: inherit;
            font-weight: 900;
            cursor: pointer;
            background: var(--aqua);
            color: var(--deep);
        }

        .content {
            padding: 24px 28px 30px;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-weight: 700;
        }

        .alert.success { background: #eafaf3; color: var(--success); }
        .alert.error { background: #fef2f2; color: #b91c1c; }

        .main-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 390px;
            gap: 22px;
            align-items: start;
        }

        .left-col {
            display: grid;
            gap: 16px;
            min-width: 0;
        }

        .toolbar,
        .products-panel,
        .checkout-panel {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: 0 14px 38px rgba(9, 25, 46, 0.08);
        }

        .toolbar {
            padding: 18px;
            display: grid;
            gap: 14px;
        }

        .toolbar-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 16px;
        }

        .kicker {
            color: var(--teal);
            font-size: 0.76rem;
            font-weight: 900;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .toolbar h2,
        .checkout-panel h2 {
            color: var(--deep);
            font-size: 1.25rem;
            line-height: 1.1;
        }

        .toolbar p {
            color: var(--muted);
            margin-top: 6px;
        }

        .filters {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        input,
        select {
            height: 44px;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0 12px;
            color: var(--text);
            font: inherit;
            background: #fff;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input:focus,
        select:focus {
            border-color: var(--aqua);
            box-shadow: 0 0 0 4px rgba(78, 205, 196, 0.16);
        }

        .filter-input,
        .filter-select {
            flex: 1 1 200px;
        }

        .product-count {
            border-radius: 999px;
            background: rgba(78, 205, 196, 0.14);
            color: var(--teal);
            padding: 8px 12px;
            font-size: 0.84rem;
            font-weight: 900;
            white-space: nowrap;
        }

        .products-panel {
            padding: 18px;
            overflow: hidden;
        }

        .products-table-scroll {
            max-height: calc(100vh - 270px);
            overflow: auto;
            border-radius: 8px;
            border: 1px solid rgba(9, 25, 46, 0.06);
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            min-width: 760px;
        }

        .product-table .col-image { width: 14%; }
        .product-table .col-product { width: 34%; }
        .product-table .col-price { width: 16%; }
        .product-table .col-stock { width: 14%; }
        .product-table .col-quantity { width: 22%; }

        th,
        td {
            padding: 14px 12px;
            border-bottom: 1px solid rgba(9, 25, 46, 0.07);
            text-align: left;
            vertical-align: middle;
        }

        th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: var(--cream);
            color: var(--muted);
            font-size: 0.78rem;
            font-weight: 900;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .product-row {
            background: #fff;
        }

        .product-image-cell img {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 8px;
            background: var(--pearl);
        }

        .product-name {
            font-weight: 900;
            color: var(--deep);
        }

        .muted {
            color: var(--muted);
            font-size: 0.88rem;
            margin-top: 4px;
        }

        .price {
            color: var(--teal);
            font-weight: 900;
        }

        .stock-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 54px;
            min-height: 30px;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(78, 205, 196, 0.14);
            color: var(--teal);
            font-weight: 900;
            font-size: 0.9rem;
        }

        .quantity-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .qty-btn {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 8px;
            background: var(--deep);
            color: #fff;
            font-size: 1.05rem;
            font-weight: 900;
            cursor: pointer;
            display: grid;
            place-items: center;
        }

        .qty-control-input {
            width: 48px;
            height: 34px;
            text-align: center;
            border-radius: 8px;
            font-weight: 900;
            padding: 0;
        }

        .checkout-panel {
            position: sticky;
            top: 22px;
            padding: 20px;
            display: grid;
            gap: 16px;
        }

        .checkout-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .checkout-count {
            color: var(--muted);
            font-size: 0.86rem;
            font-weight: 800;
        }

        .checkout-list {
            display: grid;
            gap: 10px;
            max-height: 230px;
            overflow-y: auto;
            padding-right: 2px;
        }

        .checkout-item-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
            gap: 10px;
            padding: 12px;
            border-radius: 8px;
            background: #f4fbf9;
            color: var(--deep);
        }

        .checkout-item-row strong {
            display: block;
            font-weight: 900;
        }

        .checkout-item-row span {
            display: block;
            color: var(--muted);
            font-size: 0.86rem;
            margin-top: 3px;
        }

        .checkout-empty {
            padding: 18px 14px;
            border: 1px dashed rgba(9, 25, 46, 0.18);
            border-radius: 8px;
            background: rgba(230, 245, 255, 0.62);
            color: var(--mid);
            text-align: center;
            font-size: 0.95rem;
        }

        .checkout-summary {
            display: grid;
            gap: 8px;
            border-top: 1px solid var(--border);
            padding-top: 14px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            font-weight: 800;
            color: var(--deep);
        }

        .summary-row.small {
            color: var(--muted);
            font-size: 0.92rem;
            font-weight: 600;
        }

        .checkout-total {
            color: var(--teal);
            font-size: 1.38rem;
            font-weight: 900;
        }

        .checkout-block {
            display: grid;
            gap: 10px;
        }

        .checkout-block label {
            color: var(--mid);
            font-size: 0.82rem;
            font-weight: 900;
        }

        .cash-box {
            display: none;
            gap: 10px;
            padding: 12px;
            border: 1px solid rgba(40, 122, 122, 0.22);
            border-radius: 8px;
            background: #f4fbf9;
        }

        .cash-box.active {
            display: grid;
        }

        .cash-change {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            color: var(--deep);
            font-weight: 900;
        }

        .cash-change span:last-child {
            color: var(--teal);
        }

        .segmented {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
        }

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
        }

        .segment,
        .payment-pill {
            border: 1px solid var(--border);
            border-radius: 8px;
            min-height: 42px;
            padding: 10px 8px;
            background: #fff;
            color: var(--deep);
            font: inherit;
            font-size: 0.88rem;
            font-weight: 900;
            text-align: center;
            cursor: pointer;
        }

        .segment.active,
        .payment-pill.active {
            background: rgba(78, 205, 196, 0.16);
            border-color: rgba(78, 205, 196, 0.52);
            color: var(--teal);
        }

        .customer-section {
            display: none;
            gap: 12px;
            padding: 14px;
            border: 1px solid rgba(198, 149, 78, 0.28);
            border-radius: 8px;
            background: rgba(198, 149, 78, 0.08);
        }

        .customer-section.active {
            display: grid;
        }

        .customer-hint {
            color: var(--muted);
            font-size: 0.88rem;
            line-height: 1.45;
        }

        .found-client {
            display: none;
            padding: 11px 12px;
            border-radius: 8px;
            background: #eafaf3;
            color: var(--success);
            font-weight: 800;
            line-height: 1.45;
        }

        .found-client.active {
            display: block;
        }

        .new-client-fields {
            display: none;
            gap: 10px;
        }

        .new-client-fields.active {
            display: grid;
        }

        .field-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .btn-pay {
            border: none;
            border-radius: 8px;
            padding: 15px 18px;
            min-height: 50px;
            font: inherit;
            font-weight: 900;
            cursor: pointer;
            background: linear-gradient(135deg, var(--teal) 0%, var(--aqua) 100%);
            color: #fff;
            box-shadow: 0 14px 28px rgba(40, 122, 122, 0.22);
        }

        .btn-pay:hover {
            transform: translateY(-1px);
        }

        .receipt-overlay {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 22px;
            background: rgba(9, 25, 46, 0.72);
        }

        .receipt-overlay.active {
            display: flex;
        }

        .receipt-panel {
            position: relative;
            width: min(1180px, 100%);
            max-height: calc(100vh - 44px);
            overflow: auto;
            border-radius: 8px;
            background: #fff;
            padding: 28px 34px 32px;
            box-shadow: 0 28px 80px rgba(0, 0, 0, 0.35);
        }

        .receipt-close {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 38px;
            height: 38px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            color: var(--deep);
            font-size: 1.35rem;
            font-weight: 900;
            cursor: pointer;
        }

        .receipt-title {
            text-align: center;
            color: var(--deep);
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 400;
            line-height: 1.05;
        }

        .receipt-subtitle {
            margin-top: 12px;
            text-align: center;
            color: var(--muted);
            font-size: 1.05rem;
        }

        .pdf-frame-wrap {
            margin-top: 26px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid rgba(9, 25, 46, 0.14);
            background: #303030;
        }

        .pdf-frame {
            display: block;
            width: 100%;
            height: min(58vh, 640px);
            border: 0;
            background: #303030;
        }

        .receipt-actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-top: 26px;
        }

        .receipt-action {
            min-height: 56px;
            border: 0;
            border-radius: 999px;
            color: var(--deep);
            font: inherit;
            font-weight: 900;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            cursor: pointer;
        }

        .receipt-action.download {
            background: linear-gradient(135deg, var(--teal), var(--aqua));
        }

        .receipt-action.whatsapp {
            background: #25d366;
        }

        .receipt-note {
            margin-top: 18px;
            color: var(--muted);
            text-align: center;
            line-height: 1.45;
        }

        @media (max-width: 1120px) {
            .main-grid {
                grid-template-columns: 1fr;
            }

            .checkout-panel {
                position: relative;
                top: auto;
            }

            .products-table-scroll {
                max-height: none;
            }
        }

        @media (max-width: 680px) {
            .topbar {
                align-items: flex-start;
                flex-direction: column;
                padding: 18px 16px;
            }

            .content {
                padding: 16px;
            }

            .toolbar-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .payment-methods,
            .field-grid,
            .receipt-actions {
                grid-template-columns: 1fr;
            }

            .receipt-panel {
                padding: 24px 18px;
            }

            .pdf-frame {
                height: 56vh;
            }
        }
    </style>
</head>
<body>
<div class="shell">
    <div class="topbar">
        <div class="brand">
            <img src="{{ asset('Logo.png') }}" alt="DEMAR">
            <div>
                <h1>Caja DEMAR</h1>
                <span>Sistema de ventas</span>
            </div>
        </div>
        <form method="POST" action="{{ route('cajero.logout.post') }}">
            @csrf
            <button class="btn-logout" type="submit">Cerrar sesi&oacute;n</button>
        </form>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('caja.post') }}" id="saleForm">
            @csrf

            <div class="main-grid">
                <section class="left-col" aria-label="Productos">
                    <div class="toolbar">
                        <div class="toolbar-header">
                            <div>
                                <div class="kicker">Venta en caja</div>
                                <h2>Selecciona productos</h2>
                                <p>Agrega cantidades y revisa el checkout antes de pagar.</p>
                            </div>
                            <div class="product-count">{{ $products->count() }} productos</div>
                        </div>

                        <div class="filters">
                            <input type="text" class="filter-input" placeholder="Buscar producto" id="searchProduct">
                            <select class="filter-select" id="categoryFilter">
                                <option value="all">Todas las categorias</option>
                                <option value="collar">Collares</option>
                                <option value="pulsera">Pulseras</option>
                            </select>
                        </div>
                    </div>

                    <div class="products-panel">
                        <div class="products-table-scroll">
                            <table class="product-table" id="productGrid">
                                <colgroup>
                                    <col class="col-image">
                                    <col class="col-product">
                                    <col class="col-price">
                                    <col class="col-stock">
                                    <col class="col-quantity">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        @php
                                            $imagePath = $product->imagen ?? null;
                                            $imageUrl = $imagePath ? asset($imagePath) : asset('pulseras/pulsera1.jpeg');
                                            if (strtolower($product->categoria ?? '') === 'collar') {
                                                $imageUrl = $imagePath ? asset($imagePath) : asset('collares/collar1.png');
                                            }
                                        @endphp
                                        <tr class="product-row"
                                            data-name="{{ strtolower($product->nombre) }}"
                                            data-category="{{ strtolower($product->categoria ?? '') }}"
                                            data-price="{{ $product->precio }}"
                                            data-stock="{{ $product->stock }}"
                                            data-id="{{ $product->id }}">
                                            <td class="product-image-cell">
                                                <img src="{{ $imageUrl }}" alt="{{ $product->nombre }}"
                                                     onerror="this.onerror=null; this.src='{{ asset('Logo.png') }}';">
                                            </td>
                                            <td>
                                                <div class="product-name">{{ $product->nombre }}</div>
                                                <div class="muted">{{ ucfirst($product->categoria ?? '') }}</div>
                                            </td>
                                            <td class="price">S/ {{ number_format($product->precio ?? 0, 2) }}</td>
                                            <td><span class="stock-pill">{{ $product->stock }}</span></td>
                                            <td>
                                                <div class="quantity-wrapper">
                                                    <button type="button" class="qty-btn" data-action="decrease">-</button>
                                                    <input type="text" readonly class="qty-control-input" value="0" data-quantity-display>
                                                    <button type="button" class="qty-btn" data-action="increase">+</button>
                                                </div>
                                                <input type="hidden" name="products[{{ $product->id }}][quantity]" value="0" data-hidden-qty>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <aside class="checkout-panel" aria-label="Checkout">
                    <div class="checkout-header">
                        <h2>Checkout</h2>
                        <span class="checkout-count" id="checkoutCount">0 items</span>
                    </div>

                    <div class="checkout-list" id="checkoutList">
                        <div class="checkout-empty" id="checkoutEmpty">Agrega productos para verlos aqui.</div>
                    </div>

                    <div class="checkout-summary">
                        <div class="summary-row small">
                            <span>Operaciones Gravadas</span>
                            <span id="checkoutTaxable">S/ 0.00</span>
                        </div>
                        <div class="summary-row small">
                            <span>IGV (18%)</span>
                            <span id="checkoutTax">S/ 0.00</span>
                        </div>
                        <div class="summary-row checkout-total">
                            <span>Total</span>
                            <span id="checkoutTotal">S/ 0.00</span>
                        </div>
                    </div>

                    <div class="checkout-block">
                        <label>Comprobante</label>
                        <div class="segmented" id="documentTypes">
                            <button class="segment active" type="button" data-type="boleta">Boleta</button>
                            <button class="segment" type="button" data-type="factura">Factura</button>
                        </div>
                        <input type="hidden" name="tipo_comprobante" id="tipo_comprobante" value="boleta">
                    </div>

                    <div class="customer-section" id="customerSection">
                        <div>
                            <label for="documento_cliente" id="documentLabel">DNI</label>
                            <input id="documento_cliente" name="documento_cliente" type="text" inputmode="numeric" maxlength="8" placeholder="Buscar por DNI">
                        </div>
                        <p class="customer-hint" id="customerHint">Para montos mayores a S/ 700 se requiere identificar al cliente.</p>
                        <div class="found-client" id="foundClient"></div>

                        <div class="new-client-fields" id="naturalFields">
                            <div>
                                <label for="nombres_apellidos">Nombres y apellidos</label>
                                <input id="nombres_apellidos" name="nombres_apellidos" type="text" placeholder="Nombres y apellidos">
                            </div>
                            <div>
                                <label for="telefono">Telefono</label>
                                <input id="telefono" name="telefono" type="text" placeholder="Telefono">
                            </div>
                        </div>

                        <div class="new-client-fields" id="juridicoFields">
                            <div>
                                <label for="razon_social">Razon social</label>
                                <input id="razon_social" name="razon_social" type="text" placeholder="Razon social">
                            </div>
                            <div>
                                <label for="contacto">Contacto</label>
                                <input id="contacto" name="contacto" type="text" placeholder="Contacto">
                            </div>
                        </div>
                    </div>

                    <div class="checkout-block">
                        <label>Metodo de pago</label>
                        <div class="payment-methods" id="paymentMethods">
                            <button class="payment-pill active" type="button" data-method="efectivo">Efectivo</button>
                            <button class="payment-pill" type="button" data-method="tarjeta">Tarjeta</button>
                            <button class="payment-pill" type="button" data-method="qr-yape">QR Yape</button>
                        </div>
                        <input type="hidden" name="payment_method" id="payment_method" value="efectivo">
                    </div>

                    <div class="cash-box active" id="cashBox">
                        <div>
                            <label for="cash_received">Pag&oacute; con</label>
                            <input id="cash_received" name="cash_received" type="number" min="0" step="0.10" placeholder="0.00">
                        </div>
                        <div class="cash-change">
                            <span>Vuelto</span>
                            <span id="cashChange">S/ 0.00</span>
                        </div>
                    </div>

                    <button class="btn-pay" type="submit">Pagar</button>
                </aside>
            </div>
        </form>
    </div>
</div>

@if(session('receipt'))
    <div class="receipt-overlay active" id="receiptOverlay" aria-modal="true" role="dialog" aria-labelledby="receiptTitle">
        <div class="receipt-panel">
            <button class="receipt-close" type="button" id="closeReceipt" aria-label="Cerrar comprobante">&times;</button>
            <h2 class="receipt-title" id="receiptTitle">Compra realizada con &eacute;xito</h2>
            <p class="receipt-subtitle" id="receiptSubtitle"></p>
            <div class="pdf-frame-wrap">
                <iframe class="pdf-frame" id="receiptFrame" title="Vista previa del comprobante"></iframe>
            </div>
            <div class="receipt-actions">
                <button class="receipt-action download" type="button" id="downloadReceipt">Descargar PDF</button>
                <button class="receipt-action whatsapp" type="button" id="shareReceipt">Abrir WhatsApp Web</button>
            </div>
            <p class="receipt-note" id="receiptNote">Se abrira WhatsApp Web con el chat del cliente y el mensaje del comprobante. Descarga el PDF y adjuntalo desde el chat.</p>
        </div>
    </div>
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" referrerpolicy="no-referrer"></script>
<script>
    const naturalClients = @json($clientesNaturalesJson);
    const juridicoClients = @json($clientesJuridicosJson);
    const receiptData = @json(session('receipt'));

    const searchInput = document.getElementById('searchProduct');
    const categoryFilter = document.getElementById('categoryFilter');
    const products = Array.from(document.querySelectorAll('#productGrid .product-row'));
    const checkoutList = document.getElementById('checkoutList');
    const checkoutEmpty = document.getElementById('checkoutEmpty');
    const checkoutCount = document.getElementById('checkoutCount');
    const checkoutTaxable = document.getElementById('checkoutTaxable');
    const checkoutTax = document.getElementById('checkoutTax');
    const checkoutTotal = document.getElementById('checkoutTotal');
    const paymentMethods = document.getElementById('paymentMethods');
    const paymentMethodInput = document.getElementById('payment_method');
    const documentTypes = document.getElementById('documentTypes');
    const documentTypeInput = document.getElementById('tipo_comprobante');
    const customerSection = document.getElementById('customerSection');
    const documentInput = document.getElementById('documento_cliente');
    const documentLabel = document.getElementById('documentLabel');
    const customerHint = document.getElementById('customerHint');
    const foundClient = document.getElementById('foundClient');
    const naturalFields = document.getElementById('naturalFields');
    const juridicoFields = document.getElementById('juridicoFields');
    const nombresInput = document.getElementById('nombres_apellidos');
    const telefonoInput = document.getElementById('telefono');
    const razonInput = document.getElementById('razon_social');
    const contactoInput = document.getElementById('contacto');
    const cashBox = document.getElementById('cashBox');
    const cashReceivedInput = document.getElementById('cash_received');
    const cashChange = document.getElementById('cashChange');
    const receiptOverlay = document.getElementById('receiptOverlay');
    const closeReceipt = document.getElementById('closeReceipt');
    const receiptSubtitle = document.getElementById('receiptSubtitle');
    const receiptFrame = document.getElementById('receiptFrame');
    const downloadReceipt = document.getElementById('downloadReceipt');
    const shareReceipt = document.getElementById('shareReceipt');
    const receiptNote = document.getElementById('receiptNote');

    const checkoutState = new Map();
    let currentTotal = 0;
    let receiptPdfBlob = null;
    let receiptPdfUrl = null;
    let receiptPdfFileName = '';

    function formatPrice(value) {
        return 'S/ ' + value.toFixed(2);
    }

    function formatMethod(method) {
        const labels = {
            efectivo: 'Efectivo',
            tarjeta: 'Tarjeta',
            'qr-yape': 'QR Yape',
        };

        return labels[method] || method || 'Efectivo';
    }

    function sanitizePhone(value) {
        const digits = String(value || '').replace(/\D/g, '');

        if (digits.length === 9) {
            return `51${digits}`;
        }

        return digits;
    }

    function getReceiptClientName(receipt) {
        if (!receipt?.cliente) {
            return 'Cliente General';
        }

        return receipt.tipo_comprobante === 'factura'
            ? receipt.cliente.razon_social
            : receipt.cliente.nombre;
    }

    function getReceiptPhone(receipt) {
        if (!receipt?.cliente) {
            return '';
        }

        return sanitizePhone(receipt.cliente.telefono || receipt.cliente.contacto || '');
    }

    function buildReceiptPdf(receipt) {
        const jsPDF = window.jspdf?.jsPDF;

        if (!jsPDF) {
            throw new Error('No se pudo cargar jsPDF.');
        }

        const doc = new jsPDF({ unit: 'pt', format: 'a4' });
        const typeLabel = receipt.tipo_comprobante === 'factura'
            ? 'FACTURA ELECTRONICA'
            : 'BOLETA DE VENTA ELECTRONICA';
        const fullNumber = `${receipt.serie}-${receipt.numero}`;
        const items = Array.isArray(receipt.items) ? receipt.items : [];
        const total = Number(receipt.total || 0);
        const taxable = total / 1.18;
        const tax = total - taxable;

        const pageWidth = doc.internal.pageSize.getWidth();
        const frameX = 48;
        const frameY = 58;
        const frameW = pageWidth - 96;
        const headerBoxW = 210;
        const headerBoxH = 72;
        const headerBoxX = frameX + frameW - headerBoxW - 42;
        const headerBoxY = 78;
        const headerCenterX = headerBoxX + (headerBoxW / 2);

        doc.setDrawColor(40, 122, 122);
        doc.setLineWidth(2);
        doc.rect(frameX, frameY, frameW, 720);

        doc.setFont('helvetica', 'bold');
        doc.setFontSize(26);
        doc.setTextColor(9, 25, 46);
        doc.text('DEMAR', 78, 105);

        doc.roundedRect(headerBoxX, headerBoxY, headerBoxW, headerBoxH, 8, 8);
        doc.setFontSize(11);
        doc.text(typeLabel, headerCenterX, 112, {
            align: 'center',
            maxWidth: headerBoxW - 28,
        });
        doc.setFontSize(12);
        doc.setTextColor(40, 122, 122);
        doc.text(fullNumber, headerCenterX, 139, { align: 'center' });

        doc.setDrawColor(226, 218, 204);
        doc.line(78, 196, 505, 196);

        doc.setTextColor(68, 68, 68);
        doc.setFontSize(11);
        doc.setFont('helvetica', 'bold');
        doc.text('Cliente:', 78, 230);
        doc.text('Fecha:', 338, 230);
        doc.text('Metodo de pago:', 78, 255);
        doc.setFont('helvetica', 'normal');
        doc.text(getReceiptClientName(receipt) || 'Cliente General', 142, 230);
        doc.text(String(receipt.fecha || ''), 390, 230);
        doc.text(formatMethod(receipt.metodo_pago), 170, 255);

        if (receipt.cliente) {
            doc.setFont('helvetica', 'bold');
            doc.text(receipt.tipo_comprobante === 'factura' ? 'RUC:' : 'DNI:', 78, 285);
            doc.text(receipt.tipo_comprobante === 'factura' ? 'Contacto:' : 'Telefono:', 338, 285);
            doc.setFont('helvetica', 'normal');
            doc.text(String(receipt.cliente.documento || ''), 142, 285);
            doc.text(String(receipt.cliente.contacto || receipt.cliente.telefono || ''), 410, 285);
        }

        const tableTop = receipt.cliente ? 330 : 300;
        doc.setFillColor(242, 237, 230);
        doc.rect(78, tableTop, 427, 30, 'F');
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(10);
        doc.setTextColor(9, 25, 46);
        doc.text('Producto', 88, tableTop + 19);
        doc.text('Cant.', 315, tableTop + 19);
        doc.text('Precio', 365, tableTop + 19);
        doc.text('Total', 455, tableTop + 19);

        let y = tableTop + 52;
        doc.setFont('helvetica', 'normal');
        doc.setTextColor(68, 68, 68);
        items.forEach((item) => {
            const quantity = Number(item.cantidad || 0);
            const price = Number(item.precio || 0);
            const lineTotal = quantity * price;

            doc.text(String(item.nombre || 'Producto'), 88, y, { maxWidth: 205 });
            doc.text(String(quantity), 324, y);
            doc.text(`S/ ${price.toFixed(2)}`, 365, y);
            doc.text(`S/ ${lineTotal.toFixed(2)}`, 455, y);
            y += 28;
        });

        y = Math.max(y + 16, 520);
        doc.setDrawColor(9, 25, 46);
        doc.line(315, y, 505, y);
        y += 28;
        doc.setFont('helvetica', 'bold');
        doc.text('Operaciones gravadas', 315, y);
        doc.text(`S/ ${taxable.toFixed(2)}`, 455, y);
        y += 24;
        doc.text('IGV (18%)', 315, y);
        doc.text(`S/ ${tax.toFixed(2)}`, 455, y);
        y += 30;
        doc.setFontSize(15);
        doc.setTextColor(40, 122, 122);
        doc.text('Total', 315, y);
        doc.text(`S/ ${total.toFixed(2)}`, 455, y);

        if (receipt.metodo_pago === 'efectivo') {
            const paid = Number(receipt.monto_pagado || 0);
            const change = Number(receipt.vuelto || 0);
            y += 34;
            doc.setFontSize(11);
            doc.setTextColor(68, 68, 68);
            doc.text('Pago recibido', 315, y);
            doc.text(`S/ ${paid.toFixed(2)}`, 455, y);
            y += 24;
            doc.text('Vuelto', 315, y);
            doc.text(`S/ ${change.toFixed(2)}`, 455, y);
        }

        doc.setFontSize(9);
        doc.setTextColor(107, 122, 138);
        doc.text('Gracias por tu compra.', 78, 735);

        return doc;
    }

    function showReceipt(receipt) {
        if (!receipt || !receiptOverlay) return;

        try {
            const pdf = buildReceiptPdf(receipt);
            receiptPdfBlob = pdf.output('blob');

            if (receiptPdfUrl) {
                URL.revokeObjectURL(receiptPdfUrl);
            }

            receiptPdfUrl = URL.createObjectURL(receiptPdfBlob);
            receiptPdfFileName = `${receipt.tipo_comprobante}-${receipt.serie}-${receipt.numero}.pdf`;
            receiptFrame.src = receiptPdfUrl;
            receiptSubtitle.textContent = `Tu pedido #${receipt.id} fue registrado correctamente. Este es tu archivo PDF de ${receipt.tipo_comprobante}.`;
            downloadReceipt.textContent = `Descargar ${receipt.tipo_comprobante} PDF`;
            receiptOverlay.classList.add('active');
        } catch (error) {
            receiptNote.textContent = 'La venta fue registrada, pero no se pudo generar la vista previa del PDF. Revisa tu conexion o la libreria jsPDF.';
        }
    }

    function downloadCurrentReceipt() {
        if (!receiptPdfBlob || !receiptPdfFileName) return;

        const link = document.createElement('a');
        link.href = receiptPdfUrl;
        link.download = receiptPdfFileName;
        document.body.appendChild(link);
        link.click();
        link.remove();
    }

    async function shareCurrentReceipt() {
        if (!receiptData || !receiptPdfBlob) return;

        const phone = getReceiptPhone(receiptData);
        const message = `Hola, te compartimos tu ${receiptData.tipo_comprobante} DEMAR ${receiptData.serie}-${receiptData.numero} por S/ ${Number(receiptData.total || 0).toFixed(2)}.`;

        const whatsappUrl = phone
            ? `https://web.whatsapp.com/send?phone=${phone}&text=${encodeURIComponent(message)}`
            : `https://web.whatsapp.com/send?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank', 'noopener');
        receiptNote.textContent = 'Se abrio WhatsApp Web. Descarga el PDF y adjuntalo manualmente en el chat.';
    }

    function selectedDocumentType() {
        return documentTypeInput.value || 'boleta';
    }

    function setRequired(input, required) {
        if (!input) return;
        if (required) {
            input.setAttribute('required', 'required');
        } else {
            input.removeAttribute('required');
        }
    }

    function resetCustomerFields() {
        foundClient.classList.remove('active');
        foundClient.textContent = '';
        naturalFields.classList.remove('active');
        juridicoFields.classList.remove('active');
        setRequired(nombresInput, false);
        setRequired(telefonoInput, false);
        setRequired(razonInput, false);
        setRequired(contactoInput, false);
    }

    function updateCustomerFlow() {
        const requiresCustomer = currentTotal > 700;
        const type = selectedDocumentType();
        const clients = type === 'boleta' ? naturalClients : juridicoClients;
        const expectedLength = type === 'boleta' ? 8 : 11;
        const label = type === 'boleta' ? 'DNI' : 'RUC';

        customerSection.classList.toggle('active', requiresCustomer);
        documentLabel.textContent = label;
        documentInput.placeholder = `Buscar por ${label}`;
        documentInput.maxLength = expectedLength;
        customerHint.textContent = `Para montos mayores a S/ 700 se requiere ${label} de ${type === 'boleta' ? 'persona natural' : 'persona juridica'}.`;
        setRequired(documentInput, requiresCustomer);

        resetCustomerFields();

        if (!requiresCustomer) {
            return;
        }

        documentInput.value = documentInput.value.replace(/\D/g, '').slice(0, expectedLength);
        const documentValue = documentInput.value;
        const found = clients.find(client => client.documento === documentValue);

        if (found) {
            foundClient.classList.add('active');
            foundClient.textContent = type === 'boleta'
                ? `${found.nombre} - ${found.telefono || 'Sin telefono'}`
                : `${found.nombre} - ${found.contacto || 'Sin contacto'}`;
            return;
        }

        if (documentValue.length === expectedLength) {
            if (type === 'boleta') {
                naturalFields.classList.add('active');
                setRequired(nombresInput, true);
                setRequired(telefonoInput, true);
            } else {
                juridicoFields.classList.add('active');
                setRequired(razonInput, true);
                setRequired(contactoInput, true);
            }
        }
    }

    function updateCheckout() {
        let totalItems = 0;
        let subtotal = 0;
        checkoutList.innerHTML = '';

        checkoutState.forEach((item) => {
            totalItems += item.quantity;
            subtotal += item.quantity * item.price;

            const row = document.createElement('div');
            const detail = document.createElement('div');
            const name = document.createElement('strong');
            const quantity = document.createElement('span');
            const total = document.createElement('strong');

            row.className = 'checkout-item-row';
            name.textContent = item.name;
            quantity.textContent = `${item.quantity} x ${formatPrice(item.price)}`;
            total.textContent = formatPrice(item.quantity * item.price);

            detail.append(name, quantity);
            row.append(detail, total);
            checkoutList.appendChild(row);
        });

        if (checkoutState.size === 0) {
            checkoutList.appendChild(checkoutEmpty);
        }

        const gravada = subtotal / 1.18;
        const tax = subtotal - gravada;
        currentTotal = subtotal;

        checkoutCount.textContent = `${totalItems} item${totalItems === 1 ? '' : 's'}`;
        checkoutTaxable.textContent = formatPrice(gravada);
        checkoutTax.textContent = formatPrice(tax);
        checkoutTotal.textContent = formatPrice(subtotal);
        updateCashFlow();
        updateCustomerFlow();
    }

    function updateCashFlow() {
        const isCash = paymentMethodInput.value === 'efectivo';
        cashBox?.classList.toggle('active', isCash);
        setRequired(cashReceivedInput, isCash);

        if (!cashReceivedInput || !cashChange) {
            return;
        }

        cashReceivedInput.min = currentTotal.toFixed(2);
        const received = parseFloat(cashReceivedInput.value) || 0;
        const change = Math.max(0, received - currentTotal);
        cashChange.textContent = formatPrice(change);
    }

    function applyFilters() {
        const query = (searchInput?.value || '').toLowerCase();
        const category = (categoryFilter?.value || 'all').toLowerCase();

        products.forEach(product => {
            const name = product.getAttribute('data-name') || '';
            const productCategory = product.getAttribute('data-category') || '';
            const matchesQuery = name.includes(query);
            const matchesCategory = category === 'all' || productCategory === category;
            product.style.display = matchesQuery && matchesCategory ? '' : 'none';
        });
    }

    products.forEach(product => {
        const quantityDisplay = product.querySelector('[data-quantity-display]');
        const hiddenInput = product.querySelector('[data-hidden-qty]');
        const decreaseBtn = product.querySelector('[data-action="decrease"]');
        const increaseBtn = product.querySelector('[data-action="increase"]');
        const price = parseFloat(product.getAttribute('data-price')) || 0;
        const stock = parseInt(product.getAttribute('data-stock')) || 0;
        const name = product.querySelector('.product-name')?.textContent || '';
        const id = product.getAttribute('data-id');

        function setProductQuantity(quantity) {
            const nextQuantity = Math.max(0, Math.min(quantity, stock));
            quantityDisplay.value = nextQuantity;
            hiddenInput.value = nextQuantity;

            if (nextQuantity > 0) {
                checkoutState.set(id, { name, price, quantity: nextQuantity });
            } else {
                checkoutState.delete(id);
            }

            updateCheckout();
        }

        decreaseBtn?.addEventListener('click', () => {
            const quantity = parseInt(quantityDisplay.value) || 0;
            setProductQuantity(quantity - 1);
        });

        increaseBtn?.addEventListener('click', () => {
            const quantity = parseInt(quantityDisplay.value) || 0;
            setProductQuantity(quantity + 1);
        });
    });

    searchInput?.addEventListener('input', applyFilters);
    categoryFilter?.addEventListener('change', applyFilters);
    documentInput?.addEventListener('input', updateCustomerFlow);

    documentTypes?.addEventListener('click', (event) => {
        const button = event.target.closest('.segment');
        if (!button) return;
        documentTypes.querySelectorAll('.segment').forEach(item => item.classList.remove('active'));
        button.classList.add('active');
        documentTypeInput.value = button.dataset.type || 'boleta';
        documentInput.value = '';
        updateCustomerFlow();
    });

    paymentMethods?.addEventListener('click', (event) => {
        const pill = event.target.closest('.payment-pill');
        if (!pill) return;
        paymentMethods.querySelectorAll('.payment-pill').forEach(item => item.classList.remove('active'));
        pill.classList.add('active');
        paymentMethodInput.value = pill.dataset.method || 'efectivo';
        updateCashFlow();
    });

    cashReceivedInput?.addEventListener('input', updateCashFlow);

    closeReceipt?.addEventListener('click', () => {
        receiptOverlay?.classList.remove('active');
    });

    receiptOverlay?.addEventListener('click', (event) => {
        if (event.target === receiptOverlay) {
            receiptOverlay.classList.remove('active');
        }
    });

    downloadReceipt?.addEventListener('click', downloadCurrentReceipt);
    shareReceipt?.addEventListener('click', () => {
        shareCurrentReceipt().catch(() => {
            receiptNote.textContent = 'No se pudo abrir WhatsApp desde este navegador.';
        });
    });

    applyFilters();
    updateCheckout();
    showReceipt(receiptData);
</script>
</body>
</html>
