<h2>Create Order</h2>
<form method="post" action="<?= BASE_URL ?>order/store" id="orderForm">
    <div class="row mb-3">
        <div class="col-md-6">
            <label>Customer</label>
            <select name="cusID" class="form-control" required>
                <option value="">-- Select Customer --</option>
                <?php foreach ($customers as $c): ?>
                    <option value="<?= $c['cusID'] ?>"><?= htmlspecialchars($c['CusName']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <h4>Order Items</h4>
    <table class="table table-bordered" id="itemsTable">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
                <th><button type="button" class="btn btn-sm btn-success" onclick="addRow()">+</button></th>
            </tr>
        </thead>
        <tbody id="itemsBody">
            <tr>
                <td>
                    <select name="proId[]" class="form-control product-select" required>
                        <option value="">-- Select --</option>
                        <?php foreach ($products as $p): ?>
                            <option value="<?= $p['ProID'] ?>" data-price="<?= $p['SUP'] ?>"><?= htmlspecialchars($p['ProName']) ?> (<?= $p['ProCode'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="number" name="quantity[]" class="form-control quantity" value="1" min="1" required></td>
                <td><input type="number" step="0.01" name="price[]" class="form-control price" readonly></td>
                <td class="subtotal">0.00</td>
                <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">-</button></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total:</th>
                <th id="orderTotal">0.00</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <button type="submit" class="btn btn-primary">Save Order</button>
    <a href="<?= BASE_URL ?>order" class="btn btn-secondary">Cancel</a>
</form>

<script>
function addRow() {
    let tbody = document.getElementById('itemsBody');
    let newRow = tbody.rows[0].cloneNode(true);
    newRow.querySelector('.product-select').value = '';
    newRow.querySelector('.quantity').value = '1';
    newRow.querySelector('.price').value = '';
    newRow.querySelector('.subtotal').innerText = '0.00';
    tbody.appendChild(newRow);
    attachEvents();
}

function removeRow(btn) {
    let tbody = document.getElementById('itemsBody');
    if (tbody.rows.length > 1) {
        btn.closest('tr').remove();
        calculateTotal();
    }
}

function attachEvents() {
    document.querySelectorAll('.product-select').forEach(select => {
        select.removeEventListener('change', updatePrice);
        select.addEventListener('change', updatePrice);
    });
    document.querySelectorAll('.quantity').forEach(input => {
        input.removeEventListener('input', updateSubtotal);
        input.addEventListener('input', updateSubtotal);
    });
}

function updatePrice(e) {
    let row = e.target.closest('tr');
    let priceInput = row.querySelector('.price');
    let selected = e.target.options[e.target.selectedIndex];
    let price = selected.getAttribute('data-price') || 0;
    priceInput.value = price;
    updateSubtotal({ target: row.querySelector('.quantity') });
}

function updateSubtotal(e) {
    let row = e.target.closest('tr');
    let qty = row.querySelector('.quantity').value || 0;
    let price = row.querySelector('.price').value || 0;
    let subtotal = qty * price;
    row.querySelector('.subtotal').innerText = subtotal.toFixed(2);
    calculateTotal();
}

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(cell => {
        total += parseFloat(cell.innerText) || 0;
    });
    document.getElementById('orderTotal').innerText = total.toFixed(2);
}

attachEvents();
</script>