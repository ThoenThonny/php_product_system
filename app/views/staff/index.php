<div class="container-fluid px-0">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-users me-2"></i>Staff Management</h2>
        <a href="<?= BASE_URL ?>staff/add" class="btn btn-success">
            <i class="fas fa-user-plus me-1"></i> Add New Staff
        </a>
    </div>

    <!-- Search & Filter Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="<?= BASE_URL ?>staff" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-semibold"><i class="fas fa-search"></i> Search by Name</label>
                    <input type="text" name="search" class="form-control" placeholder="Type staff name..." value="<?= htmlspecialchars($search) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold"><i class="fas fa-filter"></i> Status</label>
                    <select name="status" class="form-select">
                        <option value="all" <?= $status == 'all' ? 'selected' : '' ?>>All</option>
                        <option value="active" <?= $status == 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $status == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Staff Count Card -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Staff</h6>
                        <h2 class="mb-0"><?= count($staffs) ?></h2>
                    </div>
                    <i class="fas fa-users fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Active</h6>
                        <h2 class="mb-0"><?= count(array_filter($staffs, fn($s) => !$s['Stopwork'])) ?></h2>
                    </div>
                    <i class="fas fa-user-check fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Inactive</h6>
                        <h2 class="mb-0"><?= count(array_filter($staffs, fn($s) => $s['Stopwork'])) ?></h2>
                    </div>
                    <i class="fas fa-user-slash fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th><th>Full Name</th><th>Gender</th><th>Position</th><th>Salary</th>
                            <th>Username</th><th>Status</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($staffs)): ?>
                            <tr><td colspan="8" class="text-center text-muted py-4">No staff found. Create one?</td></tr>
                        <?php else: ?>
                            <?php foreach ($staffs as $s): ?>
                            <tr>
                                <td><?= $s['stID'] ?></td>
                                <td>
                                    <i class="fas fa-user-circle me-1 text-secondary"></i>
                                    <?= htmlspecialchars($s['FullName']) ?>
                                </td>
                                <td><?= $s['Gen'] ?></td>
                                <td><?= htmlspecialchars($s['Position'] ?: '-') ?></td>
                                <td>$<?= number_format($s['Salary'], 2) ?></td>
                                <td><?= htmlspecialchars($s['Username']) ?></td>
                                <td>
                                    <?php if ($s['Stopwork']): ?>
                                        <span class="badge bg-danger px-3 py-2">Inactive</span>
                                    <?php else: ?>
                                        <span class="badge bg-success px-3 py-2">Active</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-nowrap">
                                    <a href="<?= BASE_URL ?>staff/edit/<?= $s['stID'] ?>" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= BASE_URL ?>staff/changePassword/<?= $s['stID'] ?>" class="btn btn-sm btn-outline-warning me-1" title="Change Password">
                                        <i class="fas fa-key"></i>
                                    </a>
                                    <?php if ($s['stID'] != $_SESSION['user_id']): ?>
                                        <a href="<?= BASE_URL ?>staff/delete/<?= $s['stID'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this staff member?')" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    <?php endif; ?>
                                 </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Add FontAwesome if not already in layout -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">