<h2>Import Report</h2>
<a href="<?= BASE_URL ?>import/add" class="btn btn-success mb-3">New Import</a>
<table class="table table-bordered">
    <thead>
        <tr><th>Import Code</th><th>Date</th><th>Supplier</th><th>Staff</th><th>Total</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php foreach ($imports as $i): ?>
    <tr>
        <td><?= htmlspecialchars($i['ImportCode']) ?></td>
        <td><?= $i['ImportDate'] ?></td>
        <td><?= htmlspecialchars($i['Supplier'] ?? 'N/A') ?></td>
        <td><?= htmlspecialchars($i['StaffName'] ?? '') ?></td>
        <td>$<?= number_format($i['TotalAmount'], 2) ?></td>
        <td><a href="<?= BASE_URL ?>import/view_import_details/<?= $i['ImportID'] ?>" class="btn btn-sm btn-info">View</a>
            <a href="<?= BASE_URL ?>import/delete/<?= $i['ImportID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete import? Stock will NOT be reversed.')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>