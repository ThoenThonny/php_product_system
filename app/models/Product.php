<?php
require_once 'Model.php';

class Product extends Model {
    public function getAll() {
        $stmt = $this->pdo->query("
            SELECT p.*, s.Supplier 
            FROM tbProducts p 
            LEFT JOIN tbSuppliers s ON p.supID = s.supID 
            ORDER BY p.ProName
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM tbProducts WHERE ProID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO tbProducts (ProCode, ProName, Qty, UPIS, SUP, Status, supID, ProductImage) 
                VALUES (:ProCode, :ProName, :Qty, :UPIS, :SUP, :Status, :supID, :ProductImage)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($data) {
        $sql = "UPDATE tbProducts SET 
                ProCode = :ProCode,
                ProName = :ProName,
                Qty = :Qty,
                UPIS = :UPIS,
                SUP = :SUP,
                Status = :Status,
                supID = :supID,
                ProductImage = :ProductImage
                WHERE ProID = :ProID";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tbProducts WHERE ProID = ?");
        return $stmt->execute([$id]);
    }
    
}