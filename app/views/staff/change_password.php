<h2>Change Password for <?= htmlspecialchars($staff['FullName']) ?></h2>
<form method="post">
    <div class="mb-3">
        <label>New Password</label>
        <input type="password" name="new_password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Confirm New Password</label>
        <input type="password" name="confirm_password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Change Password</button>
    <a href="<?= BASE_URL ?>staff" class="btn btn-secondary">Cancel</a>
</form>