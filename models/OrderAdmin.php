<?php

require_once __DIR__ . "/../config/Database.php";

class OrderAdmin {

    private $conn;

    public function __construct() {

        $this->conn = (new Database())->connect();
    }

    // GET ALL ORDERS

    public function getAllOrders() {

        $sql = "SELECT
                orders.*,
                users.name
                AS customer_name
                FROM orders
                JOIN users
                ON orders.user_id = users.id
                ORDER BY order_date DESC";

        return $this->conn
        ->query($sql)
        ->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE ORDER STATUS

    public function updateStatus(
        $id,
        $status
    ) {

        $stmt = $this->conn->prepare(
            "UPDATE orders
            SET status=?
            WHERE id=?"
        );

        return $stmt->execute([
            $status,
            $id
        ]);
    }

    // TOTAL ORDERS

    public function totalOrders() {

        return $this->conn
        ->query("SELECT COUNT(*) FROM orders")
        ->fetchColumn();
    }

    // PENDING ORDERS

    public function pendingOrders() {

        return $this->conn
        ->query(
            "SELECT COUNT(*)
            FROM orders
            WHERE status='pending'"
        )
        ->fetchColumn();
    }

    // PURCHASE HISTORY

    public function purchaseHistory() {

        $sql = "SELECT
                orders.id,
                users.name,
                orders.total_amount,
                orders.status,
                orders.order_date
                FROM orders
                JOIN users
                ON orders.user_id = users.id
                ORDER BY orders.order_date DESC";

        return $this->conn
        ->query($sql)
        ->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>