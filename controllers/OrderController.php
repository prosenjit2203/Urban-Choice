<?php

require_once __DIR__ . "/../models/OrderCustomer.php";
require_once __DIR__ . "/../models/Payment.php";
require_once __DIR__ . "/../models/Cart.php";

class OrderController {

    private $order;
    private $payment;
    private $cart;

    public function __construct() {

        $this->order = new OrderCustomer();

        $this->payment = new Payment();

        $this->cart = new Cart();
    }

    // CUSTOMER LOGIN CHECK

    private function checkCustomer() {

        session_start();

        if (!isset($_SESSION["user_id"])) {

            header("Location: ../views/login.php");

            exit;
        }
    }

    // CHECKOUT

    public function checkout() {

        $this->checkCustomer();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $paymentMethod =
            trim($_POST["payment_method"]);

            if (empty($paymentMethod)) {

                die("Payment Method Required");
            }

            // CART ITEMS

            $items =
            $this->cart->getByUser(
                $_SESSION["user_id"]
            );

            // EMPTY CART CHECK

            if (count($items) == 0) {

                die("Cart is Empty");
            }

            // TOTAL

            $total = 0;

            foreach($items as $item){

                $total +=
                $item["price"]
                * $item["quantity"];
            }

            // CREATE ORDER

            $orderId =
            $this->order->createOrder(
                $_SESSION["user_id"],
                $total
            );

            // INSERT ITEMS

            foreach($items as $item){

                $this->order->addOrderItem(

                    $orderId,

                    $item["product_id"],

                    $item["quantity"],

                    $item["price"]
                );
            }

            // PAYMENT

            $this->payment->create(
                $orderId,
                $total,
                $paymentMethod
            );

            // CLEAR CART

            $this->cart->clear(
                $_SESSION["user_id"]
            );

            // REDIRECT

            header(
                "Location: ../views/order_success.php?id="
                . $orderId
            );
        }
    }
}

// ROUTER

if (isset($_GET["action"])) {

    $order = new OrderController();

    if ($_GET["action"] == "checkout") {

        $order->checkout();
    }
}
?>