<h2>Product List</h2>
<a href="<?= BASE_URL ?>product/add" class="btn btn-success mb-3">Add New Product</a>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Image</th>
            <th>Code</th>
            <th>Name</th>
            <th>Qty</th>
            <th>Cost</th>
            <th>Price</th>
            <th>Supplier</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $p): ?>
        <tr>
            <td>
                <?php if ($p['ProductImage']): ?>
                    <img src="assets/uploads/<?= htmlspecialchars($p['ProductImage']) ?>" width="50" height="50" style="object-fit: cover;">
                <?php else: ?>
                    No Image
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($p['ProCode']) ?></td>
            <td><?= htmlspecialchars($p['ProName']) ?></td>
            <td><?= $p['Qty'] ?></td>
            <td><?= number_format($p['UPIS'], 2) ?></td>
            <td><?= number_format($p['SUP'], 2) ?></td>
            <td><?= htmlspecialchars($p['Supplier'] ?? 'N/A') ?></td>
            <td><?= $p['Status'] ? 'Active' : 'Inactive' ?></td>
            <td>
                <a href="<?= BASE_URL ?>product/edit/<?= $p['ProID'] ?>" class="btn btn-sm btn-primary">Edit</a>
                <a href="<?= BASE_URL ?>product/delete/<?= $p['ProID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>