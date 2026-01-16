<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#dc2626">
    <title>Fjoy's POS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f3f4f6;
            overflow: hidden;
            height: 100vh;
            height: 100dvh;
            position: fixed;
            width: 100%;
            touch-action: manipulation;
        }

        .app-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
            height: 100dvh;
            width: 100%;
        }

        .header {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
            flex-shrink: 0;
        }

        .header h1 {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .status {
            display: flex;
            gap: 8px;
            align-items: center;
            font-size: 12px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
        }

        .main-content {
            display: flex;
            flex-direction: column;
            flex: 1;
            overflow: hidden;
        }

        .menu-section {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            -webkit-overflow-scrolling: touch;
        }

        .category-title {
            font-size: 14px;
            font-weight: 600;
            color: #6b7280;
            margin: 16px 0 8px 0;
            text-transform: uppercase;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 16px;
        }

        .menu-item {
            background: white;
            border: 2px solid #fecaca;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            min-height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            user-select: none;
            transition: all 0.2s;
        }

        .menu-item:active {
            transform: scale(0.95);
            background: #fef2f2;
            border-color: #dc2626;
        }

        .menu-item-name {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #111827;
            line-height: 1.3;
        }

        .menu-item-price {
            font-size: 18px;
            color: #dc2626;
            font-weight: 700;
        }

        .cart-section {
            background: white;
            border-top: 2px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            max-height: 45vh;
            flex-shrink: 0;
            overflow: hidden;
        }

        .cart-header {
            padding: 10px 16px;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 600;
            font-size: 14px;
            flex-shrink: 0;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
            min-height: 80px;
            -webkit-overflow-scrolling: touch;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            background: #f9fafb;
            border-radius: 8px;
            margin-bottom: 6px;
        }

        .cart-item-info {
            flex: 1;
            min-width: 0;
        }

        .cart-item-name {
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 3px;
        }

        .cart-item-price {
            color: #6b7280;
            font-size: 11px;
        }

        .cart-item-controls {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            border: none;
            background: #dc2626;
            color: white;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
        }

        .qty-btn:active {
            background: #991b1b;
        }

        .qty-display {
            min-width: 24px;
            text-align: center;
            font-weight: 600;
        }

        .cart-summary {
            padding: 10px 16px;
            border-top: 2px solid #e5e7eb;
            flex-shrink: 0;
            background: white;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .summary-row.total {
            font-size: 18px;
            font-weight: 700;
            color: #dc2626;
            padding-top: 6px;
            border-top: 2px solid #e5e7eb;
            margin-bottom: 8px;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            user-select: none;
        }

        .btn-clear {
            background: #6b7280;
            color: white;
        }

        .btn-clear:active {
            background: #4b5563;
        }

        .btn-pay {
            background: #dc2626;
            color: white;
        }

        .btn-pay:active {
            background: #991b1b;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            padding: 24px;
            max-width: 400px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .input-group {
            margin-bottom: 16px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 18px;
        }

        .quick-amounts {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-top: 8px;
        }

        .quick-amount-btn {
            padding: 12px;
            background: #f3f4f6;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            user-select: none;
        }

        .quick-amount-btn:active {
            background: #e5e7eb;
        }

        .empty-cart {
            text-align: center;
            padding: 15px;
            color: #9ca3af;
            font-size: 13px;
        }

        .flavor-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .flavor-btn {
            padding: 15px;
            background: white;
            border: 2px solid #fecaca;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            user-select: none;
            text-align: center;
            transition: all 0.2s;
        }

        .flavor-btn:active {
            background: #fef2f2;
            border-color: #dc2626;
            transform: scale(0.95);
        }

        .flavor-btn.selected {
            background: #dc2626;
            color: white;
            border-color: #991b1b;
        }

        .orders-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            margin-right: 10px;
        }

        .orders-btn:active {
            background: rgba(255, 255, 255, 0.3);
        }

        .active-orders-panel {
            position: fixed;
            top: 0;
            right: -100%;
            width: 90%;
            max-width: 400px;
            height: 100vh;
            background: white;
            box-shadow: -2px 0 10px rgba(0,0,0,0.3);
            transition: right 0.3s ease;
            z-index: 2000;
            display: flex;
            flex-direction: column;
        }

        .active-orders-panel.active {
            right: 0;
        }

        .orders-panel-header {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .orders-panel-header h2 {
            font-size: 18px;
            margin: 0;
        }

        .close-panel-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-panel-btn:active {
            background: rgba(255, 255, 255, 0.3);
        }

        .orders-panel-content {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
        }

        .empty-orders {
            text-align: center;
            padding: 40px 20px;
            color: #9ca3af;
        }

        .order-card {
            background: #f9fafb;
            border: 2px solid #fecaca;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #fecaca;
        }

        .order-number {
            font-size: 18px;
            font-weight: 700;
            color: #dc2626;
        }

        .order-time {
            font-size: 12px;
            color: #6b7280;
        }

        .order-items {
            margin: 10px 0;
        }

        .order-item-row {
            padding: 5px 0;
            font-size: 14px;
            color: #374151;
        }

        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #fecaca;
        }

        .order-total {
            font-size: 16px;
            font-weight: 700;
            color: #dc2626;
        }

        .btn-done {
            background: #10b981;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-done:active {
            background: #059669;
        }

        /* Ensure buttons are always visible */
        @supports (-webkit-touch-callout: none) {
            /* iOS specific */
            .app-container {
                height: -webkit-fill-available;
            }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <div class="header">
            <h1>🍗 FJOY'S POS</h1>
            <div class="status">
                <button class="orders-btn" onclick="window.location.href='<?= base_url('pos/reset-counter') ?>'" style="margin-right: 5px;">
                    🔄
                </button>
                <button class="orders-btn" onclick="toggleActiveOrders()">
                    📋 Orders (<span id="orderCount">0</span>)
                </button>
                <span class="status-dot" id="statusDot"></span>
                <span id="statusText">Online</span>
            </div>
        </div>

        <div class="main-content">
            <div class="menu-section" id="menuSection">
                <div class="category-title">Loading menu...</div>
            </div>

            <div class="cart-section">
                <div class="cart-header">Current Order</div>
                <div class="cart-items" id="cartItems">
                    <div class="empty-cart">Cart is empty</div>
                </div>
                <div class="cart-summary">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span id="subtotal">₱0.00</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span id="total">₱0.00</span>
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-clear" id="clearBtn" disabled>Clear</button>
                        <button class="btn btn-pay" id="payBtn" disabled>Pay Cash</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="paymentModal">
        <div class="modal-content">
            <div class="modal-title">Cash Payment</div>
            <div class="input-group">
                <label>Total Amount: <span id="modalTotal">₱0.00</span></label>
            </div>
            <div class="input-group">
                <label for="cashReceived">Cash Received:</label>
                <input type="number" id="cashReceived" step="0.01" min="0" placeholder="0.00" inputmode="decimal">
                <div class="quick-amounts">
                    <button class="quick-amount-btn" data-amount="50">₱50</button>
                    <button class="quick-amount-btn" data-amount="100">₱100</button>
                    <button class="quick-amount-btn" data-amount="200">₱200</button>
                    <button class="quick-amount-btn" data-amount="500">₱500</button>
                    <button class="quick-amount-btn" data-amount="1000">₱1000</button>
                    <button class="quick-amount-btn" id="exactBtn">Exact</button>
                </div>
            </div>
            <div class="input-group">
                <label>Change: <span id="changeAmount">₱0.00</span></label>
            </div>
            <div class="action-buttons">
                <button class="btn btn-clear" id="cancelPayBtn">Cancel</button>
                <button class="btn btn-pay" id="completePayBtn" disabled>Complete</button>
            </div>
        </div>
    </div>

    <div class="modal" id="flavorModal">
        <div class="modal-content">
            <div class="modal-title" id="flavorModalTitle">Select Flavor</div>
            <div id="flavorCounter" style="text-align: center; margin-bottom: 15px; font-weight: 600; color: #dc2626; display: none;">
                Selected: 0/2
            </div>
            <div id="flavorOptions" class="flavor-grid"></div>
            <div class="action-buttons" style="margin-top: 20px;">
                <button class="btn btn-clear" id="cancelFlavorBtn">Cancel</button>
                <button class="btn btn-pay" id="confirmFlavorBtn" disabled>Confirm</button>
            </div>
        </div>
    </div>

    <div class="active-orders-panel" id="activeOrdersPanel">
        <div class="orders-panel-header">
            <h2>Active Orders</h2>
            <button class="close-panel-btn" onclick="toggleActiveOrders()">✕</button>
        </div>
        <div class="orders-panel-content" id="activeOrdersContainer">
            <div class="empty-orders">No active orders</div>
        </div>
    </div>

    <script>
        // Configuration - Dynamic base URL that works on mobile
        const API_BASE_URL = window.location.origin;
        const API_KEY = '<?= getenv('API_KEY') ?: 'Fjoy3211' ?>';

        // State
        let cart = [];
        let products = [];
        let isOnline = navigator.onLine;
        let pendingProduct = null;
        let selectedFlavors = [];
        let activeOrders = [];
        let orderCounter = 1;

        // Flavor options
        const WING_FLAVORS = [
            'Salted Egg', 'Garlic Parmesan', 'Barbecue Sauce', 'Soy Garlic',
            'Korean Flavor', 'Teriyaki', 'Honey Butter', 'Lemon Glaze',
            'Sweet Chili', 'Buffalo'
        ];

        const FRIES_FLAVORS = ['Cheese', 'Sour Cream', 'Barbecue'];

        // Initialize
        document.addEventListener('DOMContentLoaded', async () => {
            console.log('POS App Starting...');
            await loadProducts();
            loadActiveOrders();
            setupEventListeners();
            updateOnlineStatus();
        });

        // Load Products
        async function loadProducts() {
            console.log('Loading products from API...');
            console.log('API_BASE_URL:', API_BASE_URL);
            console.log('API_KEY:', API_KEY);
            
            try {
                const url = `${API_BASE_URL}/api/products`;
                console.log('Fetching from:', url);
                
                const response = await fetch(url, {
                    headers: { 'X-API-Key': API_KEY }
                });
                
                console.log('Response status:', response.status);
                console.log('Response ok:', response.ok);
                
                if (response.ok) {
                    const data = await response.json();
                    console.log('Response data:', data);
                    products = data.data || [];
                    console.log('Products loaded:', products.length);
                } else {
                    const errorText = await response.text();
                    console.error('API Error:', response.status, errorText);
                }
            } catch (error) {
                console.error('Failed to load products:', error);
                console.error('Error details:', error.message);
            }
            
            renderMenu();
        }

        // Render Menu
        function renderMenu() {
            const menuSection = document.getElementById('menuSection');
            
            if (products.length === 0) {
                menuSection.innerHTML = `
                    <div class="category-title">No products available</div>
                    <div style="padding: 20px; text-align: center; color: #6b7280;">
                        <p>Unable to load menu items.</p>
                        <button onclick="location.reload()" style="margin-top: 20px; padding: 10px 20px; background: #dc2626; color: white; border: none; border-radius: 6px; cursor: pointer;">
                            Retry
                        </button>
                    </div>
                `;
                return;
            }
            
            const categories = {};
            products.forEach(product => {
                const cat = product.category || 'Other';
                if (!categories[cat]) categories[cat] = [];
                categories[cat].push(product);
            });
            
            let html = '';
            Object.keys(categories).sort().forEach(category => {
                html += `<div class="category-title">${category}</div>`;
                html += '<div class="menu-grid">';
                categories[category].forEach(product => {
                    html += `
                        <div class="menu-item" data-product-id="${product.id}">
                            <div class="menu-item-name">${product.name}</div>
                            <div class="menu-item-price">₱${parseFloat(product.price).toFixed(2)}</div>
                        </div>
                    `;
                });
                html += '</div>';
            });
            
            menuSection.innerHTML = html;
            
            document.querySelectorAll('.menu-item').forEach(item => {
                item.addEventListener('click', function() {
                    const productId = parseInt(this.getAttribute('data-product-id'));
                    addToCart(productId);
                });
            });
        }

        // Add to Cart
        function addToCart(productId) {
            productId = parseInt(productId);
            const product = products.find(p => parseInt(p.id) === productId);
            
            if (!product) {
                console.error('Product not found:', productId);
                return;
            }
            
            const needsFlavor = needsFlavorSelection(product.name);
            
            if (needsFlavor) {
                pendingProduct = product;
                showFlavorModal(product);
            } else {
                addToCartWithFlavor(product, null);
            }
        }

        // Check if product needs flavor selection
        function needsFlavorSelection(productName) {
            const name = productName.toLowerCase();
            
            if (name.includes('double wing meal')) return { type: 'wings', count: 2 };
            if (name.includes('wingmates')) return { type: 'wings', count: 2 };
            if (name.includes('triple feast')) return { type: 'wings', count: 2 };
            if (name.includes('wing fiesta')) return { type: 'wings', count: 4 };
            if (name.includes('wing meal') || name.includes('chicky bites')) {
                return { type: 'wings', count: 1 };
            }
            if (name.includes('fries')) {
                return { type: 'fries', count: 1 };
            }
            
            return false;
        }

        // Show flavor selection modal
        function showFlavorModal(product) {
            const flavorConfig = needsFlavorSelection(product.name);
            const flavors = flavorConfig.type === 'wings' ? WING_FLAVORS : FRIES_FLAVORS;
            const flavorCount = flavorConfig.count;
            
            selectedFlavors = [];
            
            const titleText = flavorCount > 1 
                ? `Select ${flavorCount} Flavors for ${product.name}`
                : `Select Flavor for ${product.name}`;
            
            document.getElementById('flavorModalTitle').textContent = titleText;
            document.getElementById('flavorCounter').textContent = `Selected: 0/${flavorCount}`;
            document.getElementById('flavorCounter').style.display = 'block';
            
            const flavorOptions = document.getElementById('flavorOptions');
            flavorOptions.innerHTML = '';
            
            flavors.forEach(flavor => {
                const btn = document.createElement('button');
                btn.className = 'flavor-btn';
                btn.textContent = flavor;
                btn.dataset.flavor = flavor;
                
                btn.addEventListener('click', function() {
                    if (this.classList.contains('selected')) {
                        this.classList.remove('selected');
                        selectedFlavors = selectedFlavors.filter(f => f !== flavor);
                    } else {
                        if (selectedFlavors.length < flavorCount) {
                            this.classList.add('selected');
                            selectedFlavors.push(flavor);
                        } else {
                            alert(`You can only select ${flavorCount} flavor(s)`);
                        }
                    }
                    
                    document.getElementById('flavorCounter').textContent = 
                        `Selected: ${selectedFlavors.length}/${flavorCount}`;
                    
                    document.getElementById('confirmFlavorBtn').disabled = 
                        selectedFlavors.length !== flavorCount;
                });
                
                flavorOptions.appendChild(btn);
            });
            
            document.getElementById('flavorModal').classList.add('active');
        }

        // Confirm flavor selection
        function confirmFlavorSelection() {
            if (pendingProduct && selectedFlavors.length > 0) {
                addToCartWithFlavor(pendingProduct, selectedFlavors);
                closeFlavorModal();
            }
        }

        // Close flavor modal
        function closeFlavorModal() {
            document.getElementById('flavorModal').classList.remove('active');
            document.getElementById('flavorCounter').style.display = 'none';
            pendingProduct = null;
            selectedFlavors = [];
            
            document.querySelectorAll('.flavor-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
        }

        // Add to cart with flavor
        function addToCartWithFlavor(product, flavors) {
            const productId = parseInt(product.id);
            const flavorString = flavors ? (Array.isArray(flavors) ? flavors.join(', ') : flavors) : null;
            const cartKey = flavorString ? `${productId}-${flavorString}` : `${productId}`;
            
            const existingItem = cart.find(item => item.cartKey === cartKey);
            
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({
                    id: productId,
                    cartKey: cartKey,
                    name: product.name,
                    flavor: flavorString,
                    price: parseFloat(product.price),
                    quantity: 1
                });
            }
            
            renderCart();
        }

        // Update Quantity
        function updateQuantity(cartKey, delta) {
            const item = cart.find(item => String(item.cartKey) === String(cartKey));
            
            if (!item) {
                console.error('Item not found with cartKey:', cartKey);
                return;
            }
            
            item.quantity += delta;
            
            if (item.quantity <= 0) {
                cart = cart.filter(item => String(item.cartKey) !== String(cartKey));
            }
            
            renderCart();
        }

        // Render Cart
        function renderCart() {
            const cartItems = document.getElementById('cartItems');
            const subtotalEl = document.getElementById('subtotal');
            const totalEl = document.getElementById('total');
            const clearBtn = document.getElementById('clearBtn');
            const payBtn = document.getElementById('payBtn');
            
            if (cart.length === 0) {
                cartItems.innerHTML = '<div class="empty-cart">Cart is empty</div>';
                subtotalEl.textContent = '₱0.00';
                totalEl.textContent = '₱0.00';
                clearBtn.disabled = true;
                payBtn.disabled = true;
                return;
            }
            
            let html = '';
            let subtotal = 0;
            
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                
                const displayName = item.flavor ? `${item.name} (${item.flavor})` : item.name;
                
                html += `
                    <div class="cart-item">
                        <div class="cart-item-info">
                            <div class="cart-item-name">${displayName}</div>
                            <div class="cart-item-price">₱${item.price.toFixed(2)} × ${item.quantity} = ₱${itemTotal.toFixed(2)}</div>
                        </div>
                        <div class="cart-item-controls">
                            <button class="qty-btn" data-cart-key="${item.cartKey}" data-delta="-1">−</button>
                            <div class="qty-display">${item.quantity}</div>
                            <button class="qty-btn" data-cart-key="${item.cartKey}" data-delta="1">+</button>
                        </div>
                    </div>
                `;
            });
            
            cartItems.innerHTML = html;
            subtotalEl.textContent = `₱${subtotal.toFixed(2)}`;
            totalEl.textContent = `₱${subtotal.toFixed(2)}`;
            clearBtn.disabled = false;
            payBtn.disabled = false;
            
            document.querySelectorAll('.qty-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const cartKey = this.getAttribute('data-cart-key');
                    const delta = parseInt(this.getAttribute('data-delta'));
                    updateQuantity(cartKey, delta);
                });
            });
        }

        // Clear Cart
        function clearCart() {
            if (confirm('Clear all items from cart?')) {
                cart = [];
                renderCart();
            }
        }

        // Open Payment Modal
        function openPaymentModal() {
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            document.getElementById('modalTotal').textContent = `₱${total.toFixed(2)}`;
            document.getElementById('cashReceived').value = '';
            document.getElementById('changeAmount').textContent = '₱0.00';
            document.getElementById('completePayBtn').disabled = true;
            document.getElementById('paymentModal').classList.add('active');
            setTimeout(() => document.getElementById('cashReceived').focus(), 100);
        }

        // Close Payment Modal
        function closePaymentModal() {
            document.getElementById('paymentModal').classList.remove('active');
        }

        // Calculate Change
        function calculateChange() {
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const cashReceived = parseFloat(document.getElementById('cashReceived').value) || 0;
            const change = cashReceived - total;
            
            document.getElementById('changeAmount').textContent = `₱${change.toFixed(2)}`;
            document.getElementById('completePayBtn').disabled = change < 0;
            
            return change;
        }

        // Complete Payment
        async function completePayment() {
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const cashReceived = parseFloat(document.getElementById('cashReceived').value) || 0;
            const change = calculateChange();
            
            if (change < 0) {
                alert('Insufficient cash received');
                return;
            }
            
            const orderNumber = orderCounter++;
            localStorage.setItem('orderCounter', orderCounter);
            
            const transaction = {
                transaction_id: `TXN-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`,
                device_id: getDeviceId(),
                order_number: orderNumber,
                items: cart.map(item => ({
                    product_id: item.id,
                    name: item.name,
                    flavor: item.flavor || null,
                    price: item.price,
                    quantity: item.quantity
                })),
                subtotal: total,
                total: total,
                payment_method: 'cash',
                cash_received: cashReceived,
                change_given: change,
                transaction_date: new Date().toISOString()
            };
            
            try {
                const response = await fetch(`${API_BASE_URL}/api/transactions/sync`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-API-Key': API_KEY
                    },
                    body: JSON.stringify({ transactions: [transaction] })
                });
                
                if (response.ok) {
                    console.log('Transaction synced successfully');
                }
            } catch (error) {
                console.log('Failed to sync transaction:', error);
            }
            
            addToActiveOrders(orderNumber, cart, total);
            
            alert(`Payment Complete!\n\nOrder #${orderNumber}\nTotal: ₱${total.toFixed(2)}\nCash: ₱${cashReceived.toFixed(2)}\nChange: ₱${change.toFixed(2)}`);
            
            cart = [];
            renderCart();
            closePaymentModal();
        }

        // Get Device ID
        function getDeviceId() {
            let deviceId = localStorage.getItem('device_id');
            if (!deviceId) {
                deviceId = `DEVICE-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
                localStorage.setItem('device_id', deviceId);
            }
            return deviceId;
        }

        // Active Orders Functions
        function addToActiveOrders(orderNumber, orderCart, total) {
            const order = {
                orderNumber: orderNumber,
                timestamp: new Date().toISOString(),
                items: orderCart.map(item => ({
                    name: item.name,
                    flavor: item.flavor,
                    quantity: item.quantity,
                    price: item.price
                })),
                total: total
            };
            
            activeOrders.unshift(order);
            saveActiveOrders();
            renderActiveOrders();
        }

        function loadActiveOrders() {
            const saved = localStorage.getItem('activeOrders');
            if (saved) {
                activeOrders = JSON.parse(saved);
            }
            
            const savedCounter = localStorage.getItem('orderCounter');
            if (savedCounter) {
                orderCounter = parseInt(savedCounter);
            }
            
            renderActiveOrders();
        }

        function saveActiveOrders() {
            localStorage.setItem('activeOrders', JSON.stringify(activeOrders));
        }

        function markOrderDone(orderNumber) {
            if (confirm(`Mark Order #${orderNumber} as DONE?`)) {
                activeOrders = activeOrders.filter(order => order.orderNumber !== orderNumber);
                saveActiveOrders();
                renderActiveOrders();
            }
        }

        function renderActiveOrders() {
            const container = document.getElementById('activeOrdersContainer');
            const orderCount = document.getElementById('orderCount');
            
            orderCount.textContent = activeOrders.length;
            
            if (activeOrders.length === 0) {
                container.innerHTML = '<div class="empty-orders">No active orders</div>';
                return;
            }
            
            let html = '';
            activeOrders.forEach(order => {
                const orderTime = new Date(order.timestamp).toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                html += `
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-number">Order #${order.orderNumber}</div>
                            <div class="order-time">${orderTime}</div>
                        </div>
                        <div class="order-items">
                `;
                
                order.items.forEach(item => {
                    const displayName = item.flavor ? `${item.name} (${item.flavor})` : item.name;
                    html += `
                        <div class="order-item-row">
                            ${item.quantity}x ${displayName}
                        </div>
                    `;
                });
                
                html += `
                        </div>
                        <div class="order-footer">
                            <div class="order-total">Total: ₱${order.total.toFixed(2)}</div>
                            <button class="btn-done" onclick="markOrderDone(${order.orderNumber})">DONE</button>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }

        function toggleActiveOrders() {
            const panel = document.getElementById('activeOrdersPanel');
            panel.classList.toggle('active');
        }

        // Reset order counter function
        function resetOrderCounter() {
            if (confirm('Reset order counter back to 1?\n\nThis will clear all active orders and reset the counter.')) {
                orderCounter = 1;
                activeOrders = [];
                localStorage.setItem('orderCounter', orderCounter);
                saveActiveOrders();
                renderActiveOrders();
                alert('Order counter reset to 1');
            }
        }

        // Update Online Status
        function updateOnlineStatus() {
            isOnline = navigator.onLine;
            const statusDot = document.getElementById('statusDot');
            const statusText = document.getElementById('statusText');
            
            if (isOnline) {
                statusDot.classList.remove('offline');
                statusText.textContent = 'Online';
            } else {
                statusDot.classList.add('offline');
                statusText.textContent = 'Offline';
            }
        }

        // Setup Event Listeners
        function setupEventListeners() {
            document.getElementById('clearBtn').addEventListener('click', clearCart);
            document.getElementById('payBtn').addEventListener('click', openPaymentModal);
            document.getElementById('cancelPayBtn').addEventListener('click', closePaymentModal);
            document.getElementById('completePayBtn').addEventListener('click', completePayment);
            document.getElementById('cashReceived').addEventListener('input', calculateChange);
            document.getElementById('cancelFlavorBtn').addEventListener('click', closeFlavorModal);
            document.getElementById('confirmFlavorBtn').addEventListener('click', confirmFlavorSelection);
            
            document.getElementById('exactBtn').addEventListener('click', () => {
                const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                document.getElementById('cashReceived').value = total.toFixed(2);
                calculateChange();
            });
            
            document.querySelectorAll('.quick-amount-btn[data-amount]').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('cashReceived').value = this.getAttribute('data-amount');
                    calculateChange();
                });
            });
            
            window.addEventListener('online', updateOnlineStatus);
            window.addEventListener('offline', updateOnlineStatus);
        }

        console.log('POS App Loaded');
    </script>
</body>
</html>
