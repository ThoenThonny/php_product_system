<?php
require_once 'Model.php';

class Payment extends Model {
    public function getAll() {
        $stmt = $this->pdo->query("
            SELECT p.*, s.FullName AS StaffName
            FROM tbPayments p
            LEFT JOIN tbStaffs s ON p.stID = s.stID
            ORDER BY p.PayDate DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByOrder($orderId) {
        $stmt = $this->pdo->prepare("SELECT * FROM tbPayments WHERE OrID = ? ORDER BY PayDate");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($payCode) {
        $stmt = $this->pdo->prepare("SELECT * FROM tbPayments WHERE PayCode = ?");
        $stmt->execute([$payCode]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO tbPayments (PayCode, stID, FullName, OrID, Amount) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$data['PayCode'], $data['stID'], $data['FullName'], $data['OrID'], $data['Amount']]);
    }

    public function delete($payCode) {
        $stmt = $this->pdo->prepare("DELETE FROM tbPayments WHERE PayCode = ?");
        return $stmt->execute([$payCode]);
    }
}