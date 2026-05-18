<?php

require_once __DIR__ . "/../config/Database.php";

class Payment {

    private $conn;

    public function __construct() {

        $this->conn = (new Database())->connect();
    }

    // STORE PAYMENT

    public function create(
        $order,
        $amount,
        $method
    ) {

        $transaction = uniqid("TXN");

        $stmt = $this->conn->prepare(

            "INSERT INTO payments
            (
                order_id,
                amount,
                payment_method,
                transaction_id
            )

            VALUES (?, ?, ?, ?)"
        );

        return $stmt->execute([
            $order,
            $amount,
            $method,
            $transaction
        ]);
    }
}
?>