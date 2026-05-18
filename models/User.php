<?php

require_once __DIR__ . "/../config/Database.php";

class User {

    private $conn;

    public function __construct() {

        $this->conn = (new Database())->connect();
    }

    public function create($name, $email, $password, $role, $address, $phone) {

        $sql = "INSERT INTO users
                (name,email,password_hash,role,address,phone)
                VALUES(?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            htmlspecialchars($name),
            htmlspecialchars($email),
            $password,
            $role,
            htmlspecialchars($address),
            htmlspecialchars($phone)
        ]);
    }

    public function findByEmail($email) {

        $stmt = $this->conn->prepare(
            "SELECT * FROM users WHERE email=?"
        );

        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {

        $stmt = $this->conn->prepare(
            "SELECT * FROM users WHERE id=?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $name, $address, $phone) {

        $stmt = $this->conn->prepare(
            "UPDATE users
            SET name=?, address=?, phone=?
            WHERE id=?"
        );

        return $stmt->execute([
            htmlspecialchars($name),
            htmlspecialchars($address),
            htmlspecialchars($phone),
            $id
        ]);
    }
}
?>