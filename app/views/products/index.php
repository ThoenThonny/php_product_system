<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: #f4f6f9;
        }
        .product-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #2c3e50, #1a2632);
            color: white;
            padding: 1rem 1.5rem;
            border-bottom: none;
        }
        .card-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }
        .btn-add {
            background: #28a745;
            border: none;
            border-radius: 2rem;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .btn-add:hover {
            background: #218838;
            transform: translateY(-1px);
        }
        .search-box {
            position: relative;
            max-width: 320px;
        }
        .search-box i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #6c757d;
        }
        .search-box input {
            padding-left: 40px;
            border-radius: 2rem;
            border: 1px solid #dee2e6;
            background: white;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #2c3e50;
        }
        .table tbody tr {
            transition: background 0.15s;
        }
        .table tbody tr:hover {
            background-color: #f1f9ff;
        }
        .product-img {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .badge-status {
            padding: 0.35em 0.8em;
            border-radius: 2rem;
            font-weight: 500;
            font-size: 0.75rem;
        }
        .badge-active {
            background: #d4edda;
            color: #155724;
        }
        .badge-inactive {
            background: #f8d7da;
            color: #721c24;
        }
        .action-btn {
            border-radius: 0.5rem;
            padding: 0.25rem 0.6rem;
            font-size: 0.75rem;
            margin: 0 2px;
        }
        .result-count {
            font-size: 0.875rem;
            color: #6c757d;
            margin-left: 1rem;
        }
        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: stretch !important;
            }
            .search-box {
                max-width: 100%;
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid ">
    <div class="product-card card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h2><i class="fas fa-boxes me-2"></i>Product List</h2>
            <a href="<?= BASE_URL ?>product/add" class="btn btn-add text-white">
                <i class="fas fa-plus-circle me-1"></i> Add New Product
            </a>
        </div>
        <div class="card-body p-0">
            <!-- Search & filter bar -->
            <div class="d-flex justify-content-between align-items-center flex-wrap p-3 border-bottom bg-white">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchProduct" class="form-control" placeholder="Search by product name...">
                </div>
                <div class="mt-2 mt-sm-0">
                    <span class="result-count" id="resultCount"></span>
                    <button class="btn btn-link text-decoration-none text-secondary" id="clearSearch" style="font-size:0.85rem;">
                        <i class="fas fa-times-circle"></i> Clear
                    </button>
                </div>
            </div>

            <!-- Products table - responsive -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="productTable">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Qty</th>
                            <th>Cost ($)</th>
                            <th>Price ($)</th>
                            <th>Supplier</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $p): ?>
                                <tr data-product-name="<?= strtolower(htmlspecialchars($p['ProName'])) ?>">
                                    <td>
                                        <?php if (!empty($p['ProductImage']) && file_exists('assets/uploads/' . $p['ProductImage'])): ?>
                                            <img src="assets/uploads/<?= htmlspecialchars($p['ProductImage']) ?>" alt="Product" class="product-img">
                                        <?php else: ?>
                                            <div class="bg-light d-inline-flex align-items-center justify-content-center rounded" style="width:48px;height:48px;">
                                                <i class="fas fa-image text-secondary"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-medium"><?= htmlspecialchars($p['ProCode']) ?></td>
                                    <td class="product-name"><?= htmlspecialchars($p['ProName']) ?></td>
                                    <td><?= number_format($p['Qty']) ?></td>
                                    <td>$<?= number_format($p['UPIS'], 2) ?></td>
                                    <td>$<?= number_format($p['SUP'], 2) ?></td>
                                    <td><?= htmlspecialchars($p['Supplier'] ?? '—') ?></td>
                                    <td>
                                        <?php if ($p['Status']): ?>
                                            <span class="badge-status badge-active"><i class="fas fa-check-circle me-1"></i>Active</span>
                                        <?php else: ?>
                                            <span class="badge-status badge-inactive"><i class="fas fa-ban me-1"></i>Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= BASE_URL ?>product/edit/<?= $p['ProID'] ?>" class="btn btn-sm btn-primary action-btn">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="<?= BASE_URL ?>product/delete/<?= $p['ProID'] ?>" class="btn btn-sm btn-danger action-btn" onclick="return confirm('Delete this product permanently?')">
                                            <i class="fas fa-trash-alt"></i> Del
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    <i class="fas fa-box-open fa-2x mb-2 d-block"></i> No products found. 
                                    <a href="<?= BASE_URL ?>product/add" class="alert-link">Add your first product</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Optional: simple pagination message (if you implement server pagination later) -->
            <div class="bg-white p-3 border-top text-muted small">
                <i class="fas fa-info-circle me-1"></i> Showing <span id="visibleRows">0</span> of <?= count($products) ?> products
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const searchInput = document.getElementById('searchProduct');
        const clearBtn = document.getElementById('clearSearch');
        const rows = document.querySelectorAll('#productTable tbody tr');
        const resultCountSpan = document.getElementById('resultCount');
        const visibleSpan = document.getElementById('visibleRows');

        function updateFilter() {
            const term = searchInput.value.trim().toLowerCase();
            let visibleCount = 0;
            rows.forEach(row => {
                // only filter rows that have product name cell (skip "no products" row)
                const nameCell = row.querySelector('.product-name');
                if (!nameCell) return;
                const productName = nameCell.innerText.toLowerCase();
                if (term === '' || productName.includes(term)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            // update result info
            const total = rows.length;
            resultCountSpan.innerText = term ? `Found ${visibleCount} product(s)` : '';
            if (visibleSpan) visibleSpan.innerText = visibleCount;
            // show message if no visible products
            let noRowMsg = document.getElementById('noSearchResultMsg');
            if (visibleCount === 0 && rows.length > 0) {
                if (!noRowMsg) {
                    const tbody = document.querySelector('#productTable tbody');
                    const msgRow = document.createElement('tr');
                    msgRow.id = 'noSearchResultMsg';
                    msgRow.innerHTML = `<td colspan="9" class="text-center py-4 text-muted"><i class="fas fa-search-minus me-2"></i>No product matches "${escapeHtml(term)}"</td>`;
                    tbody.appendChild(msgRow);
                } else {
                    noRowMsg.style.display = '';
                }
            } else if (noRowMsg) {
                noRowMsg.style.display = 'none';
            }
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        searchInput.addEventListener('input', updateFilter);
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            searchInput.value = '';
            updateFilter();
            searchInput.focus();
        });
        // initial count
        const totalProducts = <?= count($products) ?>;
        if (visibleSpan) visibleSpan.innerText = totalProducts;
    })();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>