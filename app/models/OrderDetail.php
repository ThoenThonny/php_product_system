<?php
require_once 'Model.php';

class OrderDetail extends Model {
    // Get all details for a specific order
    public function getByOrder($orderId) {
        $stmt = $this->pdo->prepare("
            SELECT od.*, p.ProName, p.ProCode
            FROM tbOrderDetails od
            JOIN tbProducts p ON od.ProID = p.ProID
            WHERE od.OrID = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add an item to an order
    public function addItem($orderId, $proId, $quantity, $unitPrice) {
        $sql = "INSERT INTO tbOrderDetails (OrID, ProID, Quantity, UnitPrice) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$orderId, $proId, $quantity, $unitPrice]);
    }

    // Delete all details for an order (used when deleting order)
    public function deleteByOrder($orderId) {
        $stmt = $this->pdo->prepare("DELETE FROM tbOrderDetails WHERE OrID = ?");
        return $stmt->execute([$orderId]);
    }
}