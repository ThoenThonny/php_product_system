<h2>Customer List</h2>
<a href="<?= BASE_URL ?>customer/add" class="btn btn-success mb-3">Add New Customer</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $c): ?>
        <tr>
            <td><?= $c['cusID'] ?></td>
            <td><?= htmlspecialchars($c['CusName']) ?></td>
            <td><?= htmlspecialchars($c['CusContact']) ?></td>
            <td><?= $c['Status'] ? 'Active' : 'Inactive' ?></td>
            <td>
                <a href="<?= BASE_URL ?>customer/edit/<?= $c['cusID'] ?>" class="btn btn-sm btn-primary">Edit</a>
                <a href="<?= BASE_URL ?>customer/delete/<?= $c['cusID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this customer?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>