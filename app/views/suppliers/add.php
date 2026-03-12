<h2>Add Supplier</h2>
<form method="post" action="<?= BASE_URL ?>supplier/store">
    <div class="mb-3">
        <label>Supplier Name</label>
        <input type="text" name="Supplier" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Address</label>
        <input type="text" name="SupAdd" class="form-control">
    </div>
    <div class="mb-3">
        <label>Contact</label>
        <input type="text" name="SupCon" class="form-control">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="Status" class="form-check-input" checked>
        <label class="form-check-label">Active</label>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="<?= BASE_URL ?>supplier" class="btn btn-secondary">Cancel</a>
</form>