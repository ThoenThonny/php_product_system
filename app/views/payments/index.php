<h2>Payments</h2>
<a href="<?= BASE_URL ?>payment/add" class="btn btn-success mb-3">Record Payment</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Pay Code</th>
            <th>Date</th>
            <th>Staff</th>
            <th>Order ID</th>
            <th>Amount</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($payments as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['PayCode']) ?></td>
            <td><?= $p['PayDate'] ?></td>
            <td><?= htmlspecialchars($p['StaffName']) ?></td>
            <td><?= $p['OrID'] ?></td>
            <td>$<?= number_format($p['Amount'], 2) ?></td>
            <td>
                <a href="<?= BASE_URL ?>payment/delete/<?= $p['PayCode'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete payment?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>