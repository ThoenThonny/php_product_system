<?php
require_once 'Model.php';

class Order extends Model {
    // Get all orders with staff and customer names
    public function getAll() {
        $stmt = $this->pdo->query("
            SELECT o.*, s.FullName AS StaffName, c.CusName AS CustomerName
            FROM tbOrders o
            LEFT JOIN tbStaffs s ON o.stID = s.stID
            LEFT JOIN tbCustomers c ON o.cusID = c.cusID
            ORDER BY o.OrdDate DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find a single order by ID
    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM tbOrders WHERE OrID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create a new order and return the inserted ID
    public function create($data) {
        $sql = "INSERT INTO tbOrders (stID, FullName, cusID, cusName, Total) 
                VALUES (:stID, :FullName, :cusID, :cusName, :Total)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    // Update the total of an order
    public function updateTotal($orderId, $total) {
        $stmt = $this->pdo->prepare("UPDATE tbOrders SET Total = ? WHERE OrID = ?");
        return $stmt->execute([$total, $orderId]);
    }

    // Delete an order and its related details & payments
    public function delete($id) {
        // First delete related records
        $this->pdo->prepare("DELETE FROM tbOrderDetails WHERE OrID = ?")->execute([$id]);
        $this->pdo->prepare("DELETE FROM tbPayments WHERE OrID = ?")->execute([$id]);
        // Then delete the order itself
        $stmt = $this->pdo->prepare("DELETE FROM tbOrders WHERE OrID = ?");
        return $stmt->execute([$id]);
    }
}