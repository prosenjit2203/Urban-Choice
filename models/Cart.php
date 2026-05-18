<?php

require_once __DIR__ . "/../config/Database.php";

class Cart {

    private $conn;

    public function __construct() {

        $this->conn = (new Database())->connect();
    }

    // ADD TO CART

    public function add(
        $user,
        $product,
        $qty
    ) {

        // CHECK EXISTING

        $check = $this->conn->prepare(
            "SELECT * FROM cart
            WHERE user_id=? AND product_id=?"
        );

        $check->execute([
            $user,
            $product
        ]);

        $existing = $check->fetch(PDO::FETCH_ASSOC);

        // UPDATE EXISTING

        if ($existing) {

            $newQty =
            $existing["quantity"] + $qty;

            $update = $this->conn->prepare(
                "UPDATE cart
                SET quantity=?
                WHERE id=?"
            );

            return $update->execute([
                $newQty,
                $existing["id"]
            ]);
        }

        // NEW INSERT

        $stmt = $this->conn->prepare(
            "INSERT INTO cart
            (
                user_id,
                product_id,
                quantity
            )
            VALUES (?, ?, ?)"
        );

        return $stmt->execute([
            $user,
            $product,
            $qty
        ]);
    }

    // GET CART ITEMS

    public function getByUser($user) {

        $sql = "SELECT
                cart.id,
                cart.quantity,
                products.name,
                products.price,
                products.stock,
                products.image_path,
                products.id AS product_id
                FROM cart
                JOIN products
                ON cart.product_id = products.id
                WHERE cart.user_id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([$user]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE QUANTITY

    public function updateQty(
        $id,
        $qty
    ) {

        $stmt = $this->conn->prepare(
            "UPDATE cart
            SET quantity=?
            WHERE id=?"
        );

        return $stmt->execute([
            $qty,
            $id
        ]);
    }

    // DELETE ITEM

    public function delete($id) {

        $stmt = $this->conn->prepare(
            "DELETE FROM cart WHERE id=?"
        );

        return $stmt->execute([$id]);
    }

    // TOTAL CART COUNT

    public function count($user) {

        $stmt = $this->conn->prepare(
            "SELECT SUM(quantity)
            FROM cart
            WHERE user_id=?"
        );

        $stmt->execute([$user]);

        return $stmt->fetchColumn() ?? 0;
    }

    // CLEAR CART

    public function clear($user) {

        $stmt = $this->conn->prepare(
            "DELETE FROM cart
            WHERE user_id=?"
        );

        return $stmt->execute([$user]);
    }
}
?>