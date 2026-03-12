<?php
require_once 'Model.php';

class Supplier extends Model {
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM tbSuppliers ORDER BY Supplier");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActive() {
        $stmt = $this->pdo->query("SELECT supID, Supplier FROM tbSuppliers WHERE Status = 1 ORDER BY Supplier");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM tbSuppliers WHERE supID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO tbSuppliers (Supplier, SupAdd, SupCon, Status) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$data['Supplier'], $data['SupAdd'], $data['SupCon'], $data['Status']]);
    }

    public function update($data) {
        $sql = "UPDATE tbSuppliers SET Supplier = ?, SupAdd = ?, SupCon = ?, Status = ? WHERE supID = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$data['Supplier'], $data['SupAdd'], $data['SupCon'], $data['Status'], $data['supID']]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tbSuppliers WHERE supID = ?");
        return $stmt->execute([$id]);
    }
}