<?php

require_once __DIR__ . "/../config/Database.php";

class AdminCustomer {

    private $conn;

    public function __construct() {

        $this->conn = (new Database())->connect();
    }

    // GET ALL CUSTOMERS

    public function getCustomers() {

        $stmt = $this->conn->prepare(
            "SELECT *
            FROM users
            WHERE role='customer'"
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // DELETE CUSTOMER

    public function deleteCustomer($id) {

        // DELETE CART

        $stmt1 = $this->conn->prepare(
            "DELETE FROM cart WHERE user_id=?"
        );

        $stmt1->execute([$id]);

        // DELETE ORDERS

        $stmt2 = $this->conn->prepare(
            "DELETE FROM orders WHERE user_id=?"
        );

        $stmt2->execute([$id]);

        // DELETE USER

        $stmt3 = $this->conn->prepare(
            "DELETE FROM users WHERE id=?"
        );

        return $stmt3->execute([$id]);
    }

    // TOTAL CUSTOMERS

    public function totalCustomers() {

        return $this->conn
        ->query(
            "SELECT COUNT(*)
            FROM users
            WHERE role='customer'"
        )
        ->fetchColumn();
    }
}
?>