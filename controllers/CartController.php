<?php

require_once __DIR__ . "/../models/Cart.php";
require_once __DIR__ . "/../models/Product.php";

class CartController {

    private $cart;
    private $product;

    public function __construct() {

        $this->cart = new Cart();

        $this->product = new Product();
    }

    // LOGIN CHECK

    private function checkCustomer() {

        session_start();

        if (!isset($_SESSION["user_id"])) {

            header(
                "Content-Type: application/json"
            );

            echo json_encode([
                "success" => false,
                "message" => "Login Required"
            ]);

            exit;
        }
    }

    // ADD TO CART

    public function add() {

        $this->checkCustomer();

        header(
            "Content-Type: application/json"
        );

        $product =
        $this->product->getById(
            $_POST["product_id"]
        );

        // VALIDATE PRODUCT

        if (!$product) {

            echo json_encode([
                "success" => false,
                "message" => "Product not found"
            ]);

            exit;
        }

        $qty = intval($_POST["quantity"]);

        // VALIDATE QTY

        if ($qty <= 0) {

            echo json_encode([
                "success" => false,
                "message" => "Invalid quantity"
            ]);

            exit;
        }

        // STOCK CHECK

        if ($qty > $product["stock"]) {

            echo json_encode([
                "success" => false,
                "message" => "Stock unavailable"
            ]);

            exit;
        }

        $this->cart->add(
            $_SESSION["user_id"],
            $_POST["product_id"],
            $qty
        );

        echo json_encode([
            "success" => true,
            "count" =>
            $this->cart->count(
                $_SESSION["user_id"]
            )
        ]);
    }

    // UPDATE QTY

    public function update() {

        $this->checkCustomer();

        header(
            "Content-Type: application/json"
        );

        $qty = intval($_POST["quantity"]);

        if ($qty <= 0) {

            echo json_encode([
                "success" => false
            ]);

            exit;
        }

        $this->cart->updateQty(
            $_POST["id"],
            $qty
        );

        echo json_encode([
            "success" => true
        ]);
    }

    // DELETE ITEM

    public function delete() {

        $this->checkCustomer();

        header(
            "Content-Type: application/json"
        );

        $this->cart->delete(
            $_POST["id"]
        );

        echo json_encode([
            "success" => true
        ]);
    }
}

// ROUTER

if (isset($_GET["action"])) {

    $cart = new CartController();

    if ($_GET["action"] == "add") {

        $cart->add();
    }

    if ($_GET["action"] == "update") {

        $cart->update();
    }

    if ($_GET["action"] == "delete") {

        $cart->delete();
    }
}
?>