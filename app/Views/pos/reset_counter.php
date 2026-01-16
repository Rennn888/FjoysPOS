<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Order Counter - Fjoy's POS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 16px;
            padding: 40px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        h1 {
            color: #dc2626;
            font-size: 28px;
            margin-bottom: 10px;
            text-align: center;
        }

        .subtitle {
            color: #6b7280;
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .info-box {
            background: #fef2f2;
            border: 2px solid #fecaca;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .info-box h3 {
            color: #dc2626;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .info-box p {
            color: #374151;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 8px;
        }

        .info-box ul {
            margin-left: 20px;
            color: #374151;
            font-size: 14px;
            line-height: 1.8;
        }

        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .btn {
            flex: 1;
            padding: 16px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-reset {
            background: #dc2626;
            color: white;
        }

        .btn-reset:hover {
            background: #991b1b;
        }

        .btn-cancel {
            background: #6b7280;
            color: white;
        }

        .btn-cancel:hover {
            background: #4b5563;
        }

        .success-message {
            background: #d1fae5;
            border: 2px solid #6ee7b7;
            color: #065f46;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
            display: none;
        }

        .success-message.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔄 Reset Order Counter</h1>
        <p class="subtitle">Fjoy's POS System</p>

        <div id="successMessage" class="success-message">
            ✓ Order counter has been reset to 1!
        </div>

        <div class="info-box">
            <h3>⚠️ Warning</h3>
            <p>Resetting the order counter will:</p>
            <ul>
                <li>Set the order number back to 1</li>
                <li>Clear all active orders from the display</li>
                <li>Not affect saved transactions in the database</li>
            </ul>
            <p style="margin-top: 15px;"><strong>When to reset:</strong> At the start of each day or shift.</p>
        </div>

        <div class="btn-group">
            <button class="btn btn-cancel" onclick="goBack()">Cancel</button>
            <button class="btn btn-reset" onclick="resetCounter()">Reset Counter</button>
        </div>
    </div>

    <script>
        function resetCounter() {
            if (confirm('Are you sure you want to reset the order counter to 1?\n\nThis will clear all active orders.')) {
                // Reset in localStorage
                localStorage.setItem('orderCounter', 1);
                localStorage.setItem('activeOrders', JSON.stringify([]));
                
                // Show success message
                document.getElementById('successMessage').classList.add('show');
                
                // Redirect back to POS after 2 seconds
                setTimeout(() => {
                    window.location.href = '<?= base_url('pos') ?>';
                }, 2000);
            }
        }

        function goBack() {
            window.location.href = '<?= base_url('pos') ?>';
        }
    </script>
</body>
</html>
