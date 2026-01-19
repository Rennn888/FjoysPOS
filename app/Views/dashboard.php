<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Food Stand POS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f3f4f6; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: #2563eb; color: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; }
        .header h1 { font-size: 24px; margin-bottom: 10px; }
        .nav { display: flex; gap: 10px; margin-top: 15px; }
        .nav a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 6px; }
        .nav a:hover { background: rgba(255,255,255,0.3); }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .stat-label { color: #6b7280; font-size: 14px; margin-bottom: 8px; }
        .stat-value { font-size: 32px; font-weight: 700; color: #2563eb; }
        .section { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .section h2 { margin-bottom: 15px; color: #111827; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #f9fafb; font-weight: 600; color: #374151; }
        .btn { display: inline-block; padding: 10px 20px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px; }
        .btn:hover { background: #1d4ed8; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍔 Food Stand POS - Dashboard</h1>
            <div class="nav">
                <a href="<?= base_url('dashboard') ?>">Dashboard</a>
                <a href="<?= base_url('dashboard/products') ?>">Products</a>
                <a href="<?= base_url('dashboard/reports') ?>">Reports</a>
                <a href="<?= base_url('pos') ?>" target="_blank">Open POS →</a>
            </div>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-label">Today's Sales</div>
                <div class="stat-value">₱<?= number_format($todaySales['total_sales'] ?? 0, 2) ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Monthly Sales</div>
                <div class="stat-value">₱<?= number_format($monthlySales['total_sales'] ?? 0, 2) ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Today's Transactions</div>
                <div class="stat-value"><?= $todaySales['transaction_count'] ?? 0 ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Products</div>
                <div class="stat-value"><?= count($products) ?></div>
            </div>
        </div>

        <div class="section">
            <h2>🔥 Top Selling Items (Today)</h2>
            <?php if (empty($itemSalesStats)): ?>
                <p style="color: #6b7280; padding: 20px; text-align: center;">No items sold today yet.</p>
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
                        <?php foreach (array_slice($itemSalesStats, 0, 5) as $item): ?>
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
                <?php if (count($itemSalesStats) > 5): ?>
                    <div style="text-align: center; margin-top: 15px;">
                        <a href="<?= base_url('dashboard/reports') ?>" style="color: #2563eb; text-decoration: none; font-size: 14px;">View Full Item Report →</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="section">
            <h2>Recent Transactions</h2>
            <?php if (empty($recentTransactions)): ?>
                <p style="color: #6b7280; padding: 20px; text-align: center;">No transactions yet</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentTransactions as $tx): ?>
                            <tr>
                                <td><?= esc($tx['transaction_id']) ?></td>
                                <td><?= date('M d, Y H:i', strtotime($tx['transaction_date'])) ?></td>
                                <td>₱<?= number_format($tx['total'], 2) ?></td>
                                <td><?= ucfirst($tx['payment_method']) ?></td>
                                <td><?= $tx['synced_at'] ? '✓ Synced' : '⏳ Pending' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div class="section">
            <h2>Quick Actions</h2>
            <p style="margin-bottom: 15px;">
                <a href="<?= base_url('pos') ?>" class="btn" target="_blank">Open POS Application</a>
                <a href="<?= base_url('dashboard/reports') ?>" class="btn">View Reports</a>
            </p>
        </div>
    </div>
</body>
</html>
