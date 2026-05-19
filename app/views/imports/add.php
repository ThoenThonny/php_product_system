<h2>New Import (Purchase Order)</h2>
<form method="post" action="<?= BASE_URL ?>import/store" id="importForm">
    <div class="mb-3">
        <label>Supplier</label>
        <select name="supID" class="form-control" required>
            <option value="">-- Select Supplier --</option>
            <?php foreach ($suppliers as $s): ?>
                <option value="<?= $s['supID'] ?>"><?= htmlspecialchars($s['Supplier']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Notes</label>
        <textarea name="Notes" class="form-control" rows="2"></textarea>
    </div>

    <h4>Items</h4>
    <table class="table table-bordered" id="itemsTable">
        <thead>
            <tr><th>Product</th><th>Quantity</th><th>Cost Price</th><th>Subtotal</th><th><button type="button" class="btn btn-sm btn-success" onclick="addRow()">+</button></th></tr>
        </thead>
        <tbody id="itemsBody">
            <tr>
                <td>
                    <select name="proId[]" class="form-control product-select" required>
                        <option value="">-- Select --</option>
                        <?php foreach ($products as $p): ?>
                            <option value="<?= $p['ProID'] ?>"><?= htmlspecialchars($p['ProName']) ?> (<?= $p['ProCode'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="number" name="quantity[]" class="form-control quantity" value="1" min="1" required></td>
                <td><input type="number" step="0.01" name="costPrice[]" class="form-control costPrice" required></td>
                <td class="subtotal">0.00</td>
                <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">-</button></td>
            </tr>
        </tbody>
        <tfoot>
            <tr><th colspan="3" class="text-end">Total:</th><th id="importTotal">0.00</th><th></th></tr>
        </tfoot>
    </table>
    <button type="submit" class="btn btn-primary">Save Import</button>
    <a href="<?= BASE_URL ?>import" class="btn btn-secondary">Cancel</a>
</form>

<script>
function addRow() {
    let tbody = document.getElementById('itemsBody');
    let newRow = tbody.rows[0].cloneNode(true);
    newRow.querySelector('.product-select').value = '';
    newRow.querySelector('.quantity').value = '1';
    newRow.querySelector('.costPrice').value = '';
    newRow.querySelector('.subtotal').innerText = '0.00';
    tbody.appendChild(newRow);
    attachEvents();
}
function removeRow(btn) { if(document.getElementById('itemsBody').rows.length > 1) btn.closest('tr').remove(); calculateTotal(); }
function attachEvents() {
    document.querySelectorAll('.quantity, .costPrice').forEach(el => {
        el.removeEventListener('input', updateSubtotal);
        el.addEventListener('input', updateSubtotal);
    });
}
function updateSubtotal() {
    let row = this.closest('tr');
    let qty = row.querySelector('.quantity').value || 0;
    let price = row.querySelector('.costPrice').value || 0;
    row.querySelector('.subtotal').innerText = (qty * price).toFixed(2);
    calculateTotal();
}
function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(cell => total += parseFloat(cell.innerText) || 0);
    document.getElementById('importTotal').innerText = total.toFixed(2);
}
attachEvents();
</script>