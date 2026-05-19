<h2>Edit Staff</h2>
<form method="post" action="<?= BASE_URL ?>staff/update/<?= $staff['stID'] ?>">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Full Name *</label>
            <input type="text" name="FullName" class="form-control" value="<?= htmlspecialchars($staff['FullName']) ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Gender</label>
            <select name="Gen" class="form-control">
                <option <?= $staff['Gen'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option <?= $staff['Gen'] == 'Female' ? 'selected' : '' ?>>Female</option>
                <option <?= $staff['Gen'] == 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label>Date of Birth</label>
            <input type="date" name="Dob" class="form-control" value="<?= $staff['Dob'] ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label>Position</label>
            <input type="text" name="Position" class="form-control" value="<?= htmlspecialchars($staff['Position']) ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label>Salary</label>
            <input type="number" step="0.01" name="Salary" class="form-control" value="<?= $staff['Salary'] ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label>Username *</label>
            <input type="text" name="Username" class="form-control" value="<?= htmlspecialchars($staff['Username']) ?>" required>
        </div>
        <div class="col-md-12 mb-3 form-check">
            <input type="checkbox" name="Stopwork" class="form-check-input" <?= $staff['Stopwork'] ? 'checked' : '' ?>>
            <label class="form-check-label">Inactive (Stop Work)</label>
        </div>
    </div>
    <p class="text-muted">Leave password fields empty to keep current password.</p>
    <button type="submit" class="btn btn-primary">Update Staff</button>
    <a href="<?= BASE_URL ?>staff" class="btn btn-secondary">Cancel</a>
</form>