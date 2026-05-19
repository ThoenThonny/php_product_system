<h2>Order #<?= $order['OrID'] ?></h2>
<p><strong>Date:</strong> <?= $order['OrdDate'] ?></p>
<p><strong>Staff:</strong> <?= htmlspecialchars($order['FullName']) ?></p>
<p><strong>Customer:</strong> <?= htmlspecialchars($order['cusName']) ?></p>
<p><strong>Total:</strong> $<?= number_format($order['Total'], 2) ?></p>

<h4>Items</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($details as $d): ?>
        <tr>
            <td><?= htmlspecialchars($d['ProCode']) ?></td>
            <td><?= htmlspecialchars($d['ProName']) ?></td>
            <td><?= $d['Quantity'] ?></td>
            <td>$<?= number_format($d['UnitPrice'], 2) ?></td>
            <td>$<?= number_format($d['Subtotal'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h4>Payments</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Pay Code</th>
            <th>Date</th>
            <th>Staff</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($payments as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['PayCode']) ?></td>
            <td><?= $p['PayDate'] ?></td>
            <td><?= htmlspecialchars($p['FullName']) ?></td>
            <td>$<?= number_format($p['Amount'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= BASE_URL ?>order" class="btn btn-secondary">Back to Orders</a>