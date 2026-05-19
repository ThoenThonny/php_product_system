<?php
require_once 'Model.php';

class Import extends Model {
    public function getAll() {
        $stmt = $this->pdo->query("
            SELECT i.*, s.Supplier, st.FullName AS StaffName
            FROM tbImports i
            LEFT JOIN tbSuppliers s ON i.supID = s.supID
            LEFT JOIN tbStaffs st ON i.stID = st.stID
            ORDER BY i.ImportDate DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM tbImports WHERE ImportID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO tbImports (ImportCode, supID, stID, TotalAmount, Notes) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['ImportCode'], $data['supID'], $data['stID'], 
            $data['TotalAmount'], $data['Notes']
        ]);
    }

    public function updateTotal($importId, $total) {
        $stmt = $this->pdo->prepare("UPDATE tbImports SET TotalAmount = ? WHERE ImportID = ?");
        return $stmt->execute([$total, $importId]);
    }

    public function delete($id) {
        // Details deleted by cascade
        $stmt = $this->pdo->prepare("DELETE FROM tbImports WHERE ImportID = ?");
        return $stmt->execute([$id]);
    }
}