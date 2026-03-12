<h2>Add Customer</h2>
<form method="post" action="<?= BASE_URL ?>customer/store">
    <div class="mb-3">
        <label>Customer Name</label>
        <input type="text" name="CusName" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Contact Info</label>
        <input type="text" name="CusContact" class="form-control">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="Status" class="form-check-input" checked>
        <label class="form-check-label">Active</label>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="<?= BASE_URL ?>customer" class="btn btn-secondary">Cancel</a>
</form>