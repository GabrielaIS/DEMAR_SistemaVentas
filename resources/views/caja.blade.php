<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja DEMAR</title>
    <style>
        :root {
            --deep: #09192e;
            --mid: #163352;
            --teal: #287a7a;
            --aqua: #4ecdc4;
            --pearl: #f2ede6;
            --cream: #faf8f4;
            --text: #1e2a35;
            --muted: #6b7a8a;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body {
            width: 100%;
            min-height: 100%;
        }
        body {
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
            background: var(--cream);
            color: var(--text);
            min-height: 100vh;
            padding: 0;
            overflow-x: hidden;
        }
        .shell {
            width: 100vw;
            min-height: 100vh;
            background: rgba(255,255,255,0.96);
        }
        .topbar {
            background: linear-gradient(135deg, var(--deep) 0%, var(--mid) 100%);
            color: white;
            padding: 24px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }
        .topbar h1 {
            font-size: 1.8rem;
            margin-bottom: 4px;
        }
        .btn-logout {
            border: none;
            border-radius: 999px;
            padding: 10px 20px;
            font-weight: 700;
            cursor: pointer;
            background: var(--aqua);
            color: var(--deep);
        }
        .alert {
            padding: 12px 14px;
            border-radius: 12px;
            margin-bottom: 16px;
            font-weight: 600;
        }
        .alert.success { background: #eafaf3; color: #166534; }
        .alert.error { background: #fef2f2; color: #b91c1c; }

        /* ── Main content area ── */
        .content {
            padding: 24px 28px 28px;
        }

        /* ── Two-column grid: left panel + checkout ── */
        .main-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 360px;
            gap: 24px;
            align-items: start;
        }

        /* ── Left column ── */
        .left-col {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* ── Client selector ── */
        .client-section {
            border: 1px solid rgba(9,25,46,0.08);
            border-radius: 18px;
            background: white;
            padding: 18px 20px;
        }
        .client-section .section-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 700;
            color: var(--deep);
        }
        .client-select {
            width: 100%;
            border: 1px solid rgba(9,25,46,0.12);
            border-radius: 14px;
            background: white;
            color: var(--text);
            padding: 14px 16px;
            font-size: 1rem;
            appearance: none;
            outline: none;
            cursor: pointer;
        }

        /* ── Filters ── */
        .filters {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .filter-input, .filter-select {
            border: 1px solid rgba(9,25,46,0.12);
            border-radius: 10px;
            padding: 10px 12px;
            min-width: 180px;
            background: white;
            outline: none;
            font-size: 0.95rem;
            color: var(--text);
        }

        /* ── Products panel ── */
        .products-panel {
            background: var(--cream);
            border: 1px solid rgba(9,25,46,0.08);
            border-radius: 18px;
            padding: 20px;
            overflow: hidden;
        }
        .products-table-scroll {
            max-height: calc(100vh - 350px);
            overflow: auto;
            border-radius: 12px;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            min-width: 720px;
        }
        .product-table .col-image { width: 16%; }
        .product-table .col-product { width: 32%; }
        .product-table .col-price { width: 16%; }
        .product-table .col-stock { width: 12%; }
        .product-table .col-quantity { width: 24%; }
        .product-table th,
        .product-table td {
            padding: 14px 12px;
            border-bottom: 1px solid rgba(9,25,46,0.07);
            vertical-align: middle;
        }
        .product-table th {
            text-align: left;
            font-size: 0.88rem;
            color: var(--muted);
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            background: var(--cream);
            position: sticky;
            top: 0;
            z-index: 2;
        }
        .product-row { background: white; }
        .product-image-cell img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 14px;
            background: var(--pearl);
        }
        .product-name {
            font-weight: 700;
            color: var(--deep);
            font-size: 0.97rem;
        }
        .muted { color: var(--muted); font-size: 0.88rem; }
        .price { color: var(--teal); font-weight: 700; }
        .stock-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 56px;
            padding: 7px 10px;
            border-radius: 999px;
            background: rgba(78,205,196,0.14);
            color: var(--teal);
            font-weight: 700;
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
            border-radius: 50%;
            background: var(--deep);
            color: white;
            font-size: 1.1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .qty-control-input {
            width: 46px;
            text-align: center;
            border: 1px solid rgba(9,25,46,0.12);
            border-radius: 10px;
            padding: 7px 0;
            background: #faf8f4;
            font-weight: 700;
            color: var(--deep);
        }
        /* ── Checkout panel (right col) ── */
        .checkout-panel {
            background: white;
            border-radius: 26px;
            padding: 26px;
            border: 1px solid rgba(9,25,46,0.08);
            display: flex;
            flex-direction: column;
            gap: 18px;
            box-shadow: 0 14px 36px rgba(9,25,46,0.10);
            position: sticky;
            top: 24px;
        }
        .checkout-panel h2 {
            font-size: 1.45rem;
            color: var(--deep);
            letter-spacing: 0.01em;
        }
        .checkout-list {
            display: grid;
            gap: 10px;
            max-height: 300px;
            overflow-y: auto;
            padding-right: 2px;
        }
        .checkout-item-row {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            gap: 10px;
            padding: 13px 15px;
            border-radius: 14px;
            background: #f4fbf9;
            color: var(--deep);
        }
        .checkout-item-row span { display: block; font-size: 0.88rem; color: var(--muted); }
        .checkout-item-row strong { font-weight: 800; color: var(--mid); }
        .checkout-empty {
            padding: 18px 16px;
            border-radius: 14px;
            background: rgba(230,245,255,0.75);
            color: var(--mid);
            text-align: center;
            font-size: 0.95rem;
        }
        .checkout-summary {
            display: grid;
            gap: 9px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            font-weight: 700;
            color: var(--deep);
        }
        .summary-row.small { font-weight: 500; color: var(--muted); font-size: 0.93rem; }
        .checkout-total { font-size: 1.4rem; color: var(--teal); }
        .checkout-footer { display: grid; gap: 12px; }
        .checkout-footer > label { font-weight: 700; color: var(--deep); }
        .payment-methods {
            display: flex;
            gap: 8px;
        }
        .payment-pill {
            flex: 1;
            border: 1px solid rgba(9,25,46,0.12);
            border-radius: 14px;
            padding: 11px 10px;
            background: #f8fafb;
            color: var(--deep);
            font-weight: 700;
            text-align: center;
            cursor: pointer;
            font-size: 0.88rem;
            transition: background 0.2s ease, border-color 0.2s ease;
        }
        .payment-pill.active {
            background: rgba(78,205,196,0.16);
            border-color: rgba(78,205,196,0.4);
            color: var(--teal);
        }
        .btn-pay {
            border: none;
            border-radius: 16px;
            padding: 15px 18px;
            font-weight: 800;
            font-size: 1rem;
            cursor: pointer;
            background: linear-gradient(135deg, var(--teal) 0%, var(--aqua) 100%);
            color: white;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 14px 28px rgba(40,122,122,0.24);
        }
        .btn-pay:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 30px rgba(40,122,122,0.28);
        }

        /* ── Responsive ── */
        @media (max-width: 1080px) {
            .main-grid { grid-template-columns: 1fr; }
            .checkout-panel { position: relative; top: auto; }
        }
        @media (max-width: 640px) {
            .topbar { flex-direction: column; align-items: flex-start; padding: 16px; }
            .content { padding: 16px; }
        }
    </style>
</head>
<body>
<div class="shell">

    {{-- Top bar --}}
    <div class="topbar">
        <div>
            <h1>Caja DEMAR</h1>
        </div>
        <form method="POST" action="{{ route('cajero.logout.post') }}">
            @csrf
            <button class="btn-logout" type="submit">Cerrar sesión</button>
        </form>
    </div>

    {{-- Alerts --}}
    <div class="content">
        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert error">{{ $errors->first() }}</div>
        @endif

        {{-- Single form wraps the whole grid --}}
        <form method="POST" action="{{ route('caja.post') }}">
            @csrf

            <div class="main-grid">

                {{-- ── LEFT COLUMN ── --}}
                <div class="left-col">

                    {{-- Client selector --}}
                    <div class="client-section">
                        <label class="section-label" for="client_id">Cliente</label>
                        <select id="client_id" name="client_id" class="client-select">
                            <option value="">Selecciona un cliente</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">
                                    {{ $client->nombre }} {{ $client->apellido ?? '' }} {{ $client->email ? '(' . $client->email . ')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filters --}}
                    <div class="filters">
                        <input type="text" class="filter-input" placeholder="Buscar producto" id="searchProduct">
                        <select class="filter-select" id="categoryFilter">
                            <option value="all">Todas las categorías</option>
                            <option value="collar">Collares</option>
                            <option value="pulsera">Pulseras</option>
                        </select>
                    </div>

                    {{-- Products table --}}
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
                                            <td>
                                                <span class="stock-pill">{{ $product->stock }}</span>
                                            </td>
                                            <td>
                                                <div class="quantity-wrapper">
                                                    <button type="button" class="qty-btn" data-action="decrease">−</button>
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
                </div>{{-- end .left-col --}}

                {{-- ── RIGHT COLUMN: Checkout ── --}}
                <aside class="checkout-panel">
                    <h2>Checkout</h2>

                    <div class="checkout-list" id="checkoutList">
                        <div class="checkout-empty" id="checkoutEmpty">Agrega productos para verlos aquí.</div>
                    </div>

                    <div class="checkout-summary">
                        <div class="summary-row small">
                            <span>Productos</span>
                            <span id="checkoutItemsCount">0</span>
                        </div>
                        <div class="summary-row small">
                            <span>Sub total</span>
                            <span id="checkoutSubtotal">S/ 0.00</span>
                        </div>
                        <div class="summary-row small">
                            <span>Impuesto 1.5%</span>
                            <span id="checkoutTax">S/ 0.00</span>
                        </div>
                        <div class="summary-row checkout-total">
                            <span>Total</span>
                            <span id="checkoutTotal">S/ 0.00</span>
                        </div>
                    </div>

                    <div class="checkout-footer">
                        <label for="payment_method">Método de pago</label>
                        <div class="payment-methods" id="paymentMethods">
                            <div class="payment-pill active" data-method="efectivo">Efectivo</div>
                            <div class="payment-pill" data-method="tarjeta">Tarjeta</div>
                            <div class="payment-pill" data-method="qr-yape">QR Yape</div>
                        </div>
                        <input type="hidden" name="payment_method" id="payment_method" value="efectivo">
                        <button class="btn-pay" type="submit">Pagar</button>
                    </div>
                </aside>

            </div>{{-- end .main-grid --}}
        </form>
    </div>{{-- end .content --}}
</div>{{-- end .shell --}}

<script>
    const searchInput     = document.getElementById('searchProduct');
    const categoryFilter  = document.getElementById('categoryFilter');
    const products        = Array.from(document.querySelectorAll('#productGrid .product-row'));
    const checkoutList    = document.getElementById('checkoutList');
    const checkoutEmpty   = document.getElementById('checkoutEmpty');
    const checkoutItemsCount = document.getElementById('checkoutItemsCount');
    const checkoutSubtotal   = document.getElementById('checkoutSubtotal');
    const checkoutTax        = document.getElementById('checkoutTax');
    const checkoutTotal      = document.getElementById('checkoutTotal');
    const paymentMethods     = document.getElementById('paymentMethods');
    const paymentMethodInput = document.getElementById('payment_method');

    const checkoutState = new Map();

    function formatPrice(value) {
        return 'S/ ' + value.toFixed(2);
    }

    function updateCheckout() {
        let totalItems = 0;
        let subtotal   = 0;
        checkoutList.innerHTML = '';

        checkoutState.forEach((item) => {
            totalItems += item.quantity;
            subtotal   += item.quantity * item.price;

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

        const tax   = subtotal * 0.015;
        const total = subtotal + tax;

        checkoutItemsCount.textContent = totalItems;
        checkoutSubtotal.textContent   = formatPrice(subtotal);
        checkoutTax.textContent        = formatPrice(tax);
        checkoutTotal.textContent      = formatPrice(total);
    }

    function applyFilters() {
        const query    = (searchInput?.value || '').toLowerCase();
        const category = (categoryFilter?.value || 'all').toLowerCase();

        products.forEach(product => {
            const name            = product.getAttribute('data-name') || '';
            const productCategory = product.getAttribute('data-category') || '';
            const matchesQuery    = name.includes(query);
            const matchesCategory = category === 'all' || productCategory === category;
            product.style.display = matchesQuery && matchesCategory ? '' : 'none';
        });
    }

    products.forEach(product => {
        const quantityDisplay = product.querySelector('[data-quantity-display]');
        const hiddenInput     = product.querySelector('[data-hidden-qty]');
        const decreaseBtn     = product.querySelector('[data-action="decrease"]');
        const increaseBtn     = product.querySelector('[data-action="increase"]');
        const price  = parseFloat(product.getAttribute('data-price')) || 0;
        const stock  = parseInt(product.getAttribute('data-stock'))   || 0;
        const name   = product.querySelector('.product-name')?.textContent || '';
        const id     = product.getAttribute('data-id');

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

    paymentMethods?.addEventListener('click', (event) => {
        const pill = event.target.closest('.payment-pill');
        if (!pill) return;
        paymentMethods.querySelectorAll('.payment-pill').forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
        paymentMethodInput.value = pill.dataset.method || 'efectivo';
    });

    applyFilters();
</script>
</body>
</html>
