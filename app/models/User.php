<?php
require_once 'Model.php';

class User extends Model {
    public function findByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM tbStaffs WHERE Username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO tbStaffs (FullName, Gen, Dob, Position, Salary, Stopwork, Username, PasswordHash) 
                VALUES (:FullName, :Gen, :Dob, :Position, :Salary, :Stopwork, :Username, :PasswordHash)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }
}