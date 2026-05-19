<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Product Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* ── Reset & base ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f4f4f0;
            color: #1a1a18;
            font-size: 14px;
            line-height: 1.5;
            min-height: 100vh;
        }

        /* ── Layout shell ── */
        .dash-wrap {
            width: 100%;
            margin: 0 auto;
            padding: 28px 28px 48px;
        }

        /* ── Top bar ── */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
        }
        .topbar-greeting { font-size: 20px; font-weight: 500; color: #1a1a18; }
        .topbar-sub { font-size: 13px; color: #888780; margin-top: 3px; }
        .date-pill {
            font-size: 12px;
            color: #5f5e5a;
            background: #ffffff;
            border: 0.5px solid #d3d1c7;
            border-radius: 20px;
            padding: 6px 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* ── Shared card ── */
        .card {
            background: #ffffff;
            border: 0.5px solid #d3d1c7;
            border-radius: 12px;
            overflow: hidden;
        }
        .card-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 0.5px solid #eeeee9;
        }
        .card-head-title {
            font-size: 13px;
            font-weight: 500;
            color: #1a1a18;
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .card-head-title svg { width: 15px; height: 15px; stroke: #888780; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .card-head-badge { font-size: 11px; color: #888780; }
        .card-head-link { font-size: 11px; color: #185FA5; cursor: pointer; text-decoration: none; }
        .card-head-link:hover { text-decoration: underline; }
        .card-body { padding: 14px 16px; }
        .card-body-flush { padding: 0; }

        /* ── Metric cards ── */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 10px;
        }
        .metric {
            background: #ffffff;
            border: 0.5px solid #d3d1c7;
            border-radius: 10px;
            padding: 14px 16px;
        }
        .metric-label {
            font-size: 11px;
            color: #888780;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 7px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .metric-label svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .metric-value { font-size: 22px; font-weight: 500; color: #1a1a18; line-height: 1; }
        .metric-value.danger { color: #A32D2D; }
        .metric-sub { font-size: 11px; margin-top: 5px; display: flex; align-items: center; gap: 3px; }
        .metric-sub.up   { color: #3B6D11; }
        .metric-sub.down { color: #A32D2D; }
        .metric-sub.neu  { color: #888780; }

        /* ── Two-col chart + stock row ── */
        .chart-stock-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 240px;
            gap: 10px;
            margin-bottom: 10px;
        }
        .chart-legend {
            display: flex;
            gap: 16px;
            margin-bottom: 12px;
            font-size: 11px;
            color: #888780;
        }
        .chart-legend span {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .chart-legend-swatch {
            width: 10px;
            height: 10px;
            border-radius: 2px;
            background: #378ADD;
            display: inline-block;
        }
        canvas { display: block; }

        /* ── Low stock list ── */
        .stock-list { padding: 4px 16px; }
        .stock-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0;
            border-bottom: 0.5px solid #eeeee9;
        }
        .stock-row:last-child { border-bottom: none; }
        .stock-name { font-size: 12.5px; color: #1a1a18; }
        .stock-badge {
            font-size: 11px;
            font-weight: 500;
            padding: 3px 10px;
            border-radius: 20px;
            background: #FCEBEB;
            color: #791F1F;
            border: 0.5px solid #F09595;
            white-space: nowrap;
        }
        .stock-empty { font-size: 13px; color: #3B6D11; padding: 12px 0; }

        /* ── Activity + Top products row ── */
        .act-top-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 10px;
        }
        .act-list { padding: 4px 16px; }
        .act-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 9px 0;
            border-bottom: 0.5px solid #eeeee9;
        }
        .act-item:last-child { border-bottom: none; }
        .act-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .act-icon svg { width: 14px; height: 14px; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .act-icon.order  { background: #E6F1FB; }
        .act-icon.order svg { stroke: #185FA5; }
        .act-icon.import { background: #EAF3DE; }
        .act-icon.import svg { stroke: #3B6D11; }
        .act-desc { font-size: 12.5px; color: #1a1a18; line-height: 1.4; flex: 1; }
        .act-time { font-size: 11px; color: #888780; white-space: nowrap; margin-top: 1px; }

        /* ── Top products ── */
        .top-list { padding: 4px 16px; }
        .top-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 0;
            border-bottom: 0.5px solid #eeeee9;
        }
        .top-item:last-child { border-bottom: none; }
        .top-rank { font-size: 11px; color: #b4b2a9; width: 18px; text-align: right; flex-shrink: 0; }
        .top-name { font-size: 12.5px; color: #1a1a18; flex: 1; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .top-units { font-size: 12px; color: #888780; white-space: nowrap; margin-left: 4px; }
        .top-bar-wrap { width: 70px; height: 4px; background: #f1efe8; border-radius: 2px; flex-shrink: 0; }
        .top-bar { height: 4px; border-radius: 2px; background: #639922; }

        /* ── Tables row ── */
        .tables-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
            table-layout: fixed;
        }
        .data-table th {
            font-size: 10px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: #888780;
            padding: 10px 14px;
            text-align: left;
            border-bottom: 0.5px solid #eeeee9;
        }
        .data-table td {
            padding: 10px 14px;
            color: #1a1a18;
            border-bottom: 0.5px solid #eeeee9;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table tr:hover td { background: #fafafa; }
        .data-table td.mono {
            font-family: 'DM Mono', monospace;
            font-size: 12px;
            color: #5f5e5a;
        }
        .data-table td.amt {
            text-align: right;
            font-family: 'DM Mono', monospace;
            font-size: 12px;
        }
        .data-table td.muted { color: #888780; font-size: 11px; }
        .imp-pill {
            display: inline-block;
            background: #f4f4f0;
            border: 0.5px solid #d3d1c7;
            border-radius: 4px;
            padding: 1px 7px;
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            color: #5f5e5a;
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .metrics-grid { grid-template-columns: repeat(2, 1fr); }
            .chart-stock-row,
            .act-top-row,
            .tables-row { grid-template-columns: 1fr; }
        }
        @media (max-width: 560px) {
            .metrics-grid { grid-template-columns: 1fr; }
            .dash-wrap { padding: 16px 14px 40px; }
        }
    </style>
</head>
<body>

<?php
// ── Inline SVG icon helpers ──────────────────────────────────────────────────
// These keep the template readable without a font dependency.
function icon_box()      { return '<svg viewBox="0 0 24 24"><path d="M21 16V8l-9-5L3 8v8l9 5 9-5z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>'; }
function icon_users()    { return '<svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'; }
function icon_truck()    { return '<svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>'; }
function icon_coin()     { return '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M14.8 9A2 2 0 0 0 13 8h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1-1.8-1"/><line x1="12" y1="6" x2="12" y2="8"/><line x1="12" y1="16" x2="12" y2="18"/></svg>'; }
function icon_card()     { return '<svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>'; }
function icon_clock()    { return '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>'; }
function icon_cal()      { return '<svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>'; }
function icon_alert()    { return '<svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>'; }
function icon_chart()    { return '<svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>'; }
function icon_activity() { return '<svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>'; }
function icon_trophy()   { return '<svg viewBox="0 0 24 24"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2z"/></svg>'; }
function icon_receipt()  { return '<svg viewBox="0 0 24 24"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1-2-1z"/><line x1="9" y1="9" x2="15" y2="9"/><line x1="9" y1="13" x2="15" y2="13"/></svg>'; }
function icon_package()  { return '<svg viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>'; }
function icon_cart()     { return '<svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>'; }
function icon_arrow_up() { return '<svg viewBox="0 0 24 24" style="width:11px;height:11px"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>'; }
?>

<div class="dash-wrap">

    <!-- ── Top bar ──────────────────────────────────────────────── -->
    <div class="topbar">
        <div>
            <div class="topbar-greeting">
                Good <?= (date('G') < 12 ? 'morning' : (date('G') < 17 ? 'afternoon' : 'evening')) ?>,
                <?= htmlspecialchars($_SESSION['user_name'] ?? 'Staff') ?>
            </div>
            <div class="topbar-sub">Here's what's happening with your store today.</div>
        </div>
        <div class="date-pill">
            <?= icon_cal() ?>
            <?= date('l, d M Y') ?>
        </div>
    </div>

    <!-- ── Primary metrics ──────────────────────────────────────── -->
    <div class="metrics-grid">
        <div class="metric">
            <div class="metric-label"><?= icon_box() ?> Total products</div>
            <div class="metric-value"><?= number_format($totalProducts) ?></div>
            <div class="metric-sub neu">In inventory</div>
        </div>
        <div class="metric">
            <div class="metric-label"><?= icon_users() ?> Customers</div>
            <div class="metric-value"><?= number_format($totalCustomers) ?></div>
            <div class="metric-sub neu">Registered</div>
        </div>
        <div class="metric">
            <div class="metric-label"><?= icon_truck() ?> Suppliers</div>
            <div class="metric-value"><?= number_format($totalSuppliers) ?></div>
            <div class="metric-sub neu">Active</div>
        </div>
        <div class="metric">
            <div class="metric-label"><?= icon_coin() ?> All-time sales</div>
            <div class="metric-value">$<?= number_format($totalSales, 0) ?></div>
            <div class="metric-sub up"><?= icon_arrow_up() ?> All time</div>
        </div>
    </div>

    <!-- ── Secondary metrics ────────────────────────────────────── -->
    <div class="metrics-grid">
        <div class="metric">
            <div class="metric-label"><?= icon_card() ?> Payments received</div>
            <div class="metric-value">$<?= number_format($totalPayments, 0) ?></div>
            <div class="metric-sub up">Collected</div>
        </div>
        <div class="metric">
            <div class="metric-label"><?= icon_clock() ?> Pending balance</div>
            <div class="metric-value">$<?= number_format($pendingBalance, 0) ?></div>
            <div class="metric-sub <?= $pendingBalance > 0 ? 'down' : 'up' ?>">
                <?= $pendingBalance > 0 ? 'Awaiting payment' : 'Fully collected' ?>
            </div>
        </div>
        <div class="metric">
            <div class="metric-label"><?= icon_cal() ?> Today's sales</div>
            <div class="metric-value">$<?= number_format($todaySalesAmount, 0) ?></div>
            <div class="metric-sub neu"><?= $todayOrdersCount ?> order<?= $todayOrdersCount != 1 ? 's' : '' ?> today</div>
        </div>
        <div class="metric">
            <div class="metric-label"><?= icon_alert() ?> Low stock items</div>
            <div class="metric-value <?= count($lowStock) > 0 ? 'danger' : '' ?>"><?= count($lowStock) ?></div>
            <div class="metric-sub <?= count($lowStock) > 0 ? 'down' : 'up' ?>">
                <?= count($lowStock) > 0 ? 'Need restocking' : 'All levels healthy' ?>
            </div>
        </div>
    </div>

    <!-- ── Sales chart + Low stock ──────────────────────────────── -->
    <div class="chart-stock-row">

        <div class="card">
            <div class="card-head">
                <div class="card-head-title"><?= icon_chart() ?> Monthly sales</div>
                <div class="card-head-badge">Last 6 months</div>
            </div>
            <div class="card-body">
                <div class="chart-legend">
                    <span><span class="chart-legend-swatch"></span> Sales ($)</span>
                </div>
                <div style="position:relative;width:100%;height:220px">
                    <canvas id="salesChart" role="img"
                        aria-label="Bar chart of monthly sales for the last 6 months: <?= implode(', ', array_map(fn($m) => $m['month'].': $'.number_format($m['total'],2), $monthlySales)) ?>">
                        <?php foreach ($monthlySales as $m): ?><?= htmlspecialchars($m['month']) ?>: $<?= number_format($m['total'], 2) ?>. <?php endforeach; ?>
                    </canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="card-head-title" style="color:#A32D2D">
                    <svg viewBox="0 0 24 24" style="width:15px;height:15px;stroke:#A32D2D;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Low stock alert
                </div>
            </div>
            <div class="stock-list">
                <?php if (!empty($lowStock)): ?>
                    <?php foreach ($lowStock as $l): ?>
                    <div class="stock-row">
                        <span class="stock-name"><?= htmlspecialchars($l['ProName']) ?></span>
                        <span class="stock-badge">Qty: <?= (int)$l['Qty'] ?></span>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="stock-empty">All stock levels are healthy.</div>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- ── Recent activity + Top products ───────────────────────── -->
    <div class="act-top-row">

        <div class="card">
            <div class="card-head">
                <div class="card-head-title"><?= icon_activity() ?> Recent activity</div>
                <div class="card-head-badge">Latest</div>
            </div>
            <div class="act-list">
                <?php foreach ($recentActivities as $act): ?>
                <div class="act-item">
                    <div class="act-icon <?= $act['type'] === 'order' ? 'order' : 'import' ?>">
                        <?= $act['type'] === 'order' ? icon_cart() : icon_package() ?>
                    </div>
                    <div style="flex:1">
                        <div class="act-desc"><?= htmlspecialchars($act['description']) ?></div>
                        <div class="act-time"><?= date('d M H:i', strtotime($act['date'])) ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if (empty($recentActivities)): ?>
                    <div style="font-size:13px;color:#888780;padding:12px 0">No recent activity.</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="card-head-title"><?= icon_trophy() ?> Top selling products</div>
                <div class="card-head-badge">All time</div>
            </div>
            <div class="top-list">
                <?php
                $maxSold = !empty($topProducts) ? max(array_column($topProducts, 'total_sold')) : 1;
                $rank = 1;
                foreach ($topProducts as $tp):
                    $pct = round(($tp['total_sold'] / $maxSold) * 100);
                ?>
                <div class="top-item">
                    <span class="top-rank"><?= $rank++ ?></span>
                    <span class="top-name" title="<?= htmlspecialchars($tp['ProName']) ?>"><?= htmlspecialchars($tp['ProName']) ?></span>
                    <span class="top-units"><?= number_format($tp['total_sold']) ?></span>
                    <div class="top-bar-wrap"><div class="top-bar" style="width:<?= $pct ?>%"></div></div>
                </div>
                <?php endforeach; ?>
                <?php if (empty($topProducts)): ?>
                    <div style="font-size:13px;color:#888780;padding:12px 0">No sales data yet.</div>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- ── Recent orders + Recent imports ───────────────────────── -->
    <div class="tables-row">

        <div class="card">
            <div class="card-head">
                <div class="card-head-title"><?= icon_receipt() ?> Recent orders</div>
                <a href="<?= BASE_URL ?>orders" class="card-head-link">View all →</a>
            </div>
            <div class="card-body-flush">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:90px">Order #</th>
                            <th style="width:90px">Date</th>
                            <th>Customer</th>
                            <th style="width:90px;text-align:right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentOrders as $o): ?>
                        <tr>
                            <td class="mono"><?= htmlspecialchars($o['OrID']) ?></td>
                            <td class="muted"><?= date('d M Y', strtotime($o['OrdDate'])) ?></td>
                            <td><?= htmlspecialchars($o['cusName']) ?></td>
                            <td class="amt">$<?= number_format($o['Total'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($recentOrders)): ?>
                        <tr><td colspan="4" style="color:#888780;font-size:13px">No orders yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="card-head-title"><?= icon_package() ?> Recent imports</div>
                <a href="<?= BASE_URL ?>import" class="card-head-link">View all →</a>
            </div>
            <div class="card-body-flush">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Import code</th>
                            <th style="width:80px">Date</th>
                            <th style="width:90px;text-align:right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentImports as $imp): ?>
                        <tr>
                            <td><span class="imp-pill"><?= htmlspecialchars($imp['ImportCode']) ?></span></td>
                            <td class="muted"><?= date('d M Y', strtotime($imp['ImportDate'])) ?></td>
                            <td class="amt">$<?= number_format($imp['TotalAmount'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($recentImports)): ?>
                        <tr><td colspan="3" style="color:#888780;font-size:13px">No imports yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div><!-- /.dash-wrap -->

<script>
(function () {
    const labels  = <?= json_encode(array_column($monthlySales, 'month')) ?>;
    const totals  = <?= json_encode(array_map('floatval', array_column($monthlySales, 'total'))) ?>;

    new Chart(document.getElementById('salesChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Sales ($)',
                data: totals,
                backgroundColor: '#B5D4F4',
                borderColor: '#378ADD',
                borderWidth: 1,
                borderRadius: 5,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (ctx) => '$' + ctx.raw.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: { font: { size: 11, family: "'DM Sans', sans-serif" }, color: '#888780' }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    border: { display: false },
                    ticks: {
                        font: { size: 11, family: "'DM Sans', sans-serif" },
                        color: '#888780',
                        callback: (v) => '$' + v.toLocaleString()
                    }
                }
            }
        }
    });
})();
</script>

</body>
</html>