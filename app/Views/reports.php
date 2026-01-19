<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Food Stand POS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f3f4f6; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: #2563eb; color: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; }
        .header h1 { font-size: 24px; margin-bottom: 10px; }
        .nav { display: flex; gap: 10px; margin-top: 15px; }
        .nav a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 6px; }
        .nav a:hover { background: rgba(255,255,255,0.3); }
        .section { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .section h2 { margin-bottom: 15px; color: #111827; }
        .filter-form { display: flex; gap: 10px; margin-bottom: 20px; align-items: end; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { margin-bottom: 5px; font-size: 14px; color: #374151; }
        .form-group input { padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; }
        .btn { padding: 8px 20px; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer; }
        .btn:hover { background: #1d4ed8; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #f9fafb; font-weight: 600; color: #374151; }
        .summary { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .summary-card { background: #f9fafb; padding: 15px; border-radius: 6px; }
        .summary-label { font-size: 14px; color: #6b7280; margin-bottom: 5px; }
        .summary-value { font-size: 24px; font-weight: 700; color: #2563eb; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍔 Food Stand POS - Sales Reports</h1>
            <div class="nav">
                <a href="<?= base_url('dashboard') ?>">Dashboard</a>
                <a href="<?= base_url('dashboard/products') ?>">Products</a>
                <a href="<?= base_url('dashboard/reports') ?>">Reports</a>
                <a href="<?= base_url('pos') ?>" target="_blank">Open POS →</a>
            </div>
        </div>

        <div class="section">
            <h2>Filter Report</h2>
            <form method="get" class="filter-form">
                <div class="form-group">
                    <label>Start Date:</label>
                    <input type="date" name="start_date" value="<?= esc($start_date) ?>" required>
                </div>
                <div class="form-group">
                    <label>End Date:</label>
                    <input type="date" name="end_date" value="<?= esc($end_date) ?>" required>
                </div>
                <button type="submit" class="btn">Generate Report</button>
            </form>
        </div>

        <?php if (!empty($transactions)): ?>
            <?php
                $totalSales = array_sum(array_column($transactions, 'total'));
                $totalTransactions = count($transactions);
                $avgTransaction = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;
            ?>
            <div class="section">
                <h2>Summary</h2>
                <div class="summary">
                    <div class="summary-card">
                        <div class="summary-label">Total Sales</div>
                        <div class="summary-value">₱<?= number_format($totalSales, 2) ?></div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-label">Transactions</div>
                        <div class="summary-value"><?= $totalTransactions ?></div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-label">Average Sale</div>
                        <div class="summary-value">₱<?= number_format($avgTransaction, 2) ?></div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>Item Sales Breakdown</h2>
                <?php if (empty($itemSalesStats)): ?>
                    <p style="color: #6b7280; padding: 20px; text-align: center;">No items sold in this period.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th style="text-align: right;">Quantity Sold</th>
                                <th style="text-align: right;">Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($itemSalesStats as $item): ?>
                                <tr>
                                    <td>
                                        <span style="font-weight: 600; color: #1f2937;"><?= esc($item['name']) ?></span>
                                    </td>
                                    <td style="text-align: right; font-weight: bold; color: #dc2626;">
                                        <?= number_format($item['quantity']) ?>
                                    </td>
                                    <td style="text-align: right;">
                                        ₱<?= number_format($item['total'], 2) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <div class="section">
                <h2>Transaction Details</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Transaction ID</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $tx): ?>
                            <?php $items = json_decode($tx['items'], true); ?>
                            <tr>
                                <td><?= date('M d, Y H:i', strtotime($tx['transaction_date'])) ?></td>
                                <td><?= esc($tx['transaction_id']) ?></td>
                                <td><?= count($items) ?> items</td>
                                <td>₱<?= number_format($tx['total'], 2) ?></td>
                                <td><?= ucfirst($tx['payment_method']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="section">
                <p style="color: #6b7280; padding: 20px; text-align: center;">No transactions found for the selected period</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
