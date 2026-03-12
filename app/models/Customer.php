<?php
require_once 'Model.php';

class Customer extends Model {
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM tbCustomers ORDER BY CusName");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActive() {
        $stmt = $this->pdo->query("SELECT cusID, CusName FROM tbCustomers WHERE Status = 1 ORDER BY CusName");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM tbCustomers WHERE cusID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO tbCustomers (CusName, CusContact, Status) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$data['CusName'], $data['CusContact'], $data['Status']]);
    }

    public function update($data) {
        $sql = "UPDATE tbCustomers SET CusName = ?, CusContact = ?, Status = ? WHERE cusID = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$data['CusName'], $data['CusContact'], $data['Status'], $data['cusID']]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tbCustomers WHERE cusID = ?");
        return $stmt->execute([$id]);
    }
}