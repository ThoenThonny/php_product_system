<h2>Add Product</h2>
<form method="post" action="<?= BASE_URL ?>product/store" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Product Code</label>
        <input type="text" name="ProCode" class="form-control" required maxlength="50">
    </div>
    <div class="mb-3">
        <label>Product Name</label>
        <input type="text" name="ProName" class="form-control" required>
    </div>
    <div class="row">
        <div class="col-md-3 mb-3">
            <label>Quantity</label>
            <input type="number" name="Qty" class="form-control" value="0">
        </div>
        <div class="col-md-3 mb-3">
            <label>Cost (UPIS)</label>
            <input type="number" step="0.01" name="UPIS" class="form-control" required>
        </div>
        <div class="col-md-3 mb-3">
            <label>Selling Price (SUP)</label>
            <input type="number" step="0.01" name="SUP" class="form-control" required>
        </div>
        <div class="col-md-3 mb-3">
            <label>Supplier</label>
            <select name="supID" class="form-control">
                <option value="">-- Select Supplier --</option>
                <?php foreach ($suppliers as $s): ?>
                    <option value="<?= $s['supID'] ?>"><?= htmlspecialchars($s['Supplier']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="mb-3">
        <label>Product Image</label>
        <input type="file" name="ProductImage" class="form-control" accept="image/*">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="Status" class="form-check-input" checked>
        <label class="form-check-label">Active</label>
    </div>
    <button type="submit" class="btn btn-primary">Save Product</button>
    <a href="<?= BASE_URL ?>product" class="btn btn-secondary">Cancel</a>
</form>