<h2>Orders</h2>
<a href="<?= BASE_URL ?>order/add" class="btn btn-success mb-3">Create New Order</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Staff</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $o): ?>
        <tr>
            <td><?= $o['OrID'] ?></td>
            <td><?= $o['OrdDate'] ?></td>
            <td><?= htmlspecialchars($o['StaffName']) ?></td>
            <td><?= htmlspecialchars($o['CustomerName']) ?></td>
            <td>$<?= number_format($o['Total'], 2) ?></td>
            <td>
                <a href="<?= BASE_URL ?>order/view_order/<?= $o['OrID'] ?>" class="btn btn-sm btn-info">View</a>
                <a href="<?= BASE_URL ?>order/delete/<?= $o['OrID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this order?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>