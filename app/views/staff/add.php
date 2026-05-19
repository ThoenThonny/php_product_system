<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-user-plus me-2"></i>Add New Staff</h2>
        <a href="<?= BASE_URL ?>staff" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" action="<?= BASE_URL ?>staff/store">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold"><i class="fas fa-user"></i> Full Name *</label>
                        <input type="text" name="FullName" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold"><i class="fas fa-venus-mars"></i> Gender</label>
                        <select name="Gen" class="form-select">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold"><i class="fas fa-calendar-alt"></i> Date of Birth</label>
                        <input type="date" name="Dob" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold"><i class="fas fa-briefcase"></i> Position</label>
                        <input type="text" name="Position" class="form-control" placeholder="e.g., Cashier, Manager">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold"><i class="fas fa-dollar-sign"></i> Salary</label>
                        <input type="number" step="0.01" name="Salary" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold"><i class="fas fa-user-tag"></i> Username *</label>
                        <input type="text" name="Username" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold"><i class="fas fa-lock"></i> Password *</label>
                        <input type="password" name="Password" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold"><i class="fas fa-lock"></i> Confirm Password *</label>
                        <input type="password" name="ConfirmPassword" class="form-control" required>
                    </div>
                    <div class="col-md-12 mb-3 form-check">
                        <input type="checkbox" name="Stopwork" class="form-check-input" id="stopwork">
                        <label class="form-check-label" for="stopwork"><i class="fas fa-ban me-1"></i> Inactive (Stop Work)</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Staff</button>
                <a href="<?= BASE_URL ?>staff" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>