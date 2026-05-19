<?php
require_once 'Model.php';

class ImportDetail extends Model {
    public function getByImport($importId) {
        $stmt = $this->pdo->prepare("
            SELECT d.*, p.ProName, p.ProCode
            FROM tbImportDetails d
            JOIN tbProducts p ON d.ProID = p.ProID
            WHERE d.ImportID = ?
        ");
        $stmt->execute([$importId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addItem($importId, $proId, $quantity, $costPrice) {
        $stmt = $this->pdo->prepare("
            INSERT INTO tbImportDetails (ImportID, ProID, Quantity, CostPrice) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$importId, $proId, $quantity, $costPrice]);
    }
}