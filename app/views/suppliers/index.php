<h2>Supplier List</h2>
<a href="<?= BASE_URL ?>supplier/add" class="btn btn-success mb-3">Add New Supplier</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Contact</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($suppliers as $s): ?>
        <tr>
            <td><?= $s['supID'] ?></td>
            <td><?= htmlspecialchars($s['Supplier']) ?></td>
            <td><?= htmlspecialchars($s['SupAdd']) ?></td>
            <td><?= htmlspecialchars($s['SupCon']) ?></td>
            <td><?= $s['Status'] ? 'Active' : 'Inactive' ?></td>
            <td>
                <a href="<?= BASE_URL ?>supplier/edit/<?= $s['supID'] ?>" class="btn btn-sm btn-primary">Edit</a>
                <a href="<?= BASE_URL ?>supplier/delete/<?= $s['supID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this supplier?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>