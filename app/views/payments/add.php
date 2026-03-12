<h2>Record Payment</h2>
<form method="post" action="<?= BASE_URL ?>payment/store">
    <div class="mb-3">
        <label>Order</label>
        <select name="OrID" class="form-control" required>
            <option value="">-- Select Order --</option>
            <?php foreach ($orders as $o): ?>
                <option value="<?= $o['OrID'] ?>" <?= (isset($_GET['order']) && $_GET['order'] == $o['OrID']) ? 'selected' : '' ?>>
                    Order #<?= $o['OrID'] ?> - <?= htmlspecialchars($o['CustomerName']) ?> ($<?= number_format($o['Total'], 2) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Amount</label>
        <input type="number" step="0.01" name="Amount" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Record Payment</button>
    <a href="<?= BASE_URL ?>payment" class="btn btn-secondary">Cancel</a>
</form>