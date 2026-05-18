<?php

require_once __DIR__ . "/../config/Database.php";

class OrderCustomer {

    private $conn;

    public function __construct() {

        $this->conn = (new Database())->connect();
    }

    // CREATE ORDER

    public function createOrder(
        $user,
        $total
    ) {

        $stmt = $this->conn->prepare(

            "INSERT INTO orders
            (
                user_id,
                total_amount,
                status
            )

            VALUES
            (
                ?,
                ?,
                'pending'
            )"
        );

        $stmt->execute([
            $user,
            $total
        ]);

        return $this->conn->lastInsertId();
    }

    // INSERT ORDER ITEMS

    public function addOrderItem(
        $order,
        $product,
        $qty,
        $price
    ) {

        $stmt = $this->conn->prepare(

            "INSERT INTO order_items
            (
                order_id,
                product_id,
                quantity,
                unit_price
            )

            VALUES (?, ?, ?, ?)"
        );

        return $stmt->execute([
            $order,
            $product,
            $qty,
            $price
        ]);
    }

    // GET USER ORDERS

    public function getOrdersByUser($user) {

        $stmt = $this->conn->prepare(

            "SELECT *
            FROM orders
            WHERE user_id=?
            ORDER BY order_date DESC"
        );

        $stmt->execute([$user]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ORDER DETAILS

    public function getOrderItems($orderId) {

        $sql = "SELECT
                order_items.quantity,
                order_items.unit_price,
                products.name

                FROM order_items

                JOIN products
                ON order_items.product_id = products.id

                WHERE order_items.order_id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([$orderId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>