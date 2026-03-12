<h2>Edit Customer</h2>
<form method="post" action="<?= BASE_URL ?>customer/update/<?= $customer['cusID'] ?>">
    <div class="mb-3">
        <label>Customer Name</label>
        <input type="text" name="CusName" class="form-control" value="<?= htmlspecialchars($customer['CusName']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Contact Info</label>
        <input type="text" name="CusContact" class="form-control" value="<?= htmlspecialchars($customer['CusContact']) ?>">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="Status" class="form-check-input" <?= $customer['Status'] ? 'checked' : '' ?>>
        <label class="form-check-label">Active</label>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= BASE_URL ?>customer" class="btn btn-secondary">Cancel</a>
</form>