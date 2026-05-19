<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Details - <?= htmlspecialchars($import['ImportCode']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Print Styles */
       @media print {
    /* Hide common sidebar/navigation elements */
    .sidebar, .side-nav, .main-sidebar, [class*="sidebar"], #sidebar, nav.navbar, .navbar, .header, .footer, .no-print {
        display: none !important;
    }
    /* Ensure main content takes full width */
    .main-content, .content-wrapper, .container-fluid {
        margin-left: 0 !important;
        padding-left: 0 !important;
    }
}
        .print-header { display: none; }
        .print-header h2 { margin: 0; }
        .print-header p { margin: 0; color: #6c757d; }
        .card-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .card-header i { margin-right: 8px; }
        .info-row { margin-bottom: 12px; }
        .info-label { font-weight: 600; width: 120px; display: inline-block; }
        .total-box { background: #f8f9fa; padding: 15px; border-radius: 8px; text-align: right; margin-top: 20px; }
        .total-box h3 { margin: 0; color: #28a745; }
    </style>
</head>
<body>

<div class="container-fluid py-4">
    <!-- Action Buttons (no print) -->
    <div class="no-print d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-file-import"></i> Import Details</h2>
        <div>
            <button onclick="window.print()" class="btn btn-primary me-2">
                <i class="fas fa-print"></i> Print / Save PDF
            </button>
            <a href="<?= BASE_URL ?>import" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Print Header (visible only when printing) -->
    <div class="print-header text-center">
        <h2>Product Management System</h2>
        <p>Import Purchase Order Details</p>
        <hr>
    </div>

    <!-- Main Card -->
    <div class="card shadow-sm">
        <div class="card-header">
            <i class="fas fa-receipt"></i> Import Order: <?= htmlspecialchars($import['ImportCode']) ?>
        </div>
        <div class="card-body">
            <!-- Information Grid -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-calendar-alt"></i> Date:</span>
                        <?= date('F d, Y H:i', strtotime($import['ImportDate'])) ?>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-truck"></i> Supplier:</span>
                        <?= htmlspecialchars($import['Supplier'] ?? 'N/A') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-user"></i> Created By:</span>
                        <?= htmlspecialchars($import['StaffName'] ?? $_SESSION['user_name'] ?? 'System') ?>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-sticky-note"></i> Notes:</span>
                        <?= !empty($import['Notes']) ? nl2br(htmlspecialchars($import['Notes'])) : '—' ?>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <h5 class="mb-3"><i class="fas fa-list-ul"></i> Imported Items</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th class="text-end">Quantity</th>
                            <th class="text-end">Cost Price</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        <?php foreach ($details as $d): ?>
                        <tr>
                            <td><?= $counter++ ?></td>
                            <td><?= htmlspecialchars($d['ProCode']) ?></td>
                            <td><?= htmlspecialchars($d['ProName']) ?></td>
                            <td class="text-end"><?= number_format($d['Quantity']) ?></td>
                            <td class="text-end">$<?= number_format($d['CostPrice'], 2) ?></td>
                            <td class="text-end">$<?= number_format($d['Subtotal'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr>
                            <th colspan="5" class="text-end">Total Amount:</th>
                            <th class="text-end">$<?= number_format($import['TotalAmount'], 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Summary Box (optional for print) -->
            <div class="total-box no-print">
                <h3>Total: $<?= number_format($import['TotalAmount'], 2) ?></h3>
                <p class="text-muted mb-0">This import added stock to the system.</p>
            </div>
        </div>
    </div>

    <!-- Footer note for print -->
    <div class="text-center text-muted mt-4 no-print">
        <small>Generated on <?= date('Y-m-d H:i:s') ?> | Product Management System</small>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>