<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#2563eb">
    <title>Food Stand POS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/pos.css') ?>">
</head>
<body>
    <div class="app-container">
        <div class="header">
            <h1>🍔 Food Stand POS</h1>
            <div class="status">
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
                        <span id="subtotal">$0.00</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span id="total">$0.00</span>
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
                <label>Total Amount: <span id="modalTotal">$0.00</span></label>
            </div>
            <div class="input-group">
                <label for="cashReceived">Cash Received:</label>
                <input type="number" id="cashReceived" step="0.01" min="0" placeholder="0.00" inputmode="decimal">
                <div class="quick-amounts">
                    <button class="quick-amount-btn" data-amount="5">$5</button>
                    <button class="quick-amount-btn" data-amount="10">$10</button>
                    <button class="quick-amount-btn" data-amount="20">$20</button>
                    <button class="quick-amount-btn" data-amount="50">$50</button>
                    <button class="quick-amount-btn" data-amount="100">$100</button>
                    <button class="quick-amount-btn" id="exactBtn">Exact</button>
                </div>
            </div>
            <div class="input-group">
                <label>Change: <span id="changeAmount">$0.00</span></label>
            </div>
            <div class="action-buttons">
                <button class="btn btn-clear" id="cancelPayBtn">Cancel</button>
                <button class="btn btn-pay" id="completePayBtn" disabled>Complete</button>
            </div>
        </div>
    </div>

    <script>
        const API_BASE_URL = '<?= base_url() ?>';
        const API_KEY = '<?= getenv('API_KEY') ?: 'Fjoy3211' ?>';
    </script>
    <script src="<?= base_url('assets/js/pos.js') ?>"></script>
</body>
</html>
