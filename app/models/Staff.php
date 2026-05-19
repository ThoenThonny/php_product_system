<?php
require_once 'Model.php';

class Staff extends Model
{


    public function getActive()
    {
        $stmt = $this->pdo->query("SELECT stID, FullName FROM tbStaffs WHERE Stopwork = 0 ORDER BY FullName");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tbStaffs WHERE stID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tbStaffs WHERE Username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO tbStaffs (FullName, Gen, Dob, Position, Salary, Stopwork, Username, PasswordHash) 
                VALUES (:FullName, :Gen, :Dob, :Position, :Salary, :Stopwork, :Username, :PasswordHash)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':FullName'   => $data['FullName'],
            ':Gen'        => $data['Gen'],
            ':Dob'        => $data['Dob'],
            ':Position'   => $data['Position'],
            ':Salary'     => $data['Salary'],
            ':Stopwork'   => $data['Stopwork'],
            ':Username'   => $data['Username'],
            ':PasswordHash' => password_hash($data['Password'], PASSWORD_DEFAULT)
        ]);
    }

    public function update($data)
    {
        $sql = "UPDATE tbStaffs SET FullName = :FullName, Gen = :Gen, Dob = :Dob, 
                Position = :Position, Salary = :Salary, Stopwork = :Stopwork, Username = :Username 
                WHERE stID = :stID";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':FullName' => $data['FullName'],
            ':Gen'      => $data['Gen'],
            ':Dob'      => $data['Dob'],
            ':Position' => $data['Position'],
            ':Salary'   => $data['Salary'],
            ':Stopwork' => $data['Stopwork'],
            ':Username' => $data['Username'],
            ':stID'     => $data['stID']
        ]);
    }

    public function updatePassword($id, $newPassword)
    {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE tbStaffs SET PasswordHash = ? WHERE stID = ?");
        return $stmt->execute([$hash, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM tbStaffs WHERE stID = ?");
        return $stmt->execute([$id]);
    }
    public function getAll($status = 'all')
    {
        $sql = "SELECT * FROM tbStaffs";
        if ($status == 'active') {
            $sql .= " WHERE Stopwork = 0";
        } elseif ($status == 'inactive') {
            $sql .= " WHERE Stopwork = 1";
        }
        $sql .= " ORDER BY FullName";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchByName($keyword, $status = 'all')
    {
        $sql = "SELECT * FROM tbStaffs WHERE FullName LIKE :keyword";
        if ($status == 'active') {
            $sql .= " AND Stopwork = 0";
        } elseif ($status == 'inactive') {
            $sql .= " AND Stopwork = 1";
        }
        $sql .= " ORDER BY FullName";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
