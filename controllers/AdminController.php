<?php

require_once __DIR__ . "/../models/Product.php";
require_once __DIR__ . "/../models/AdminCustomer.php";
require_once __DIR__ . "/../models/OrderAdmin.php";

class AdminController {

    private $product;
    private $customer;
    private $order;

    public function __construct() {

        $this->product = new Product();

        $this->customer = new AdminCustomer();

        $this->order = new OrderAdmin();
    }

    // ADMIN CHECK

    private function checkAdmin() {

        if(session_status() == PHP_SESSION_NONE){

            session_start();
        }

        if (
            !isset($_SESSION["role"]) ||
            $_SESSION["role"] != "admin"
        ) {

            header(
                "Location: ../views/login.php"
            );

            exit;
        }
    }

    // ADD PRODUCT

    public function addProduct() {

        $this->checkAdmin();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $name = trim($_POST["name"]);

            $description = trim($_POST["description"]);

            $sizeChart = trim($_POST["size_chart"]);

            $price = trim($_POST["price"]);

            $category = trim($_POST["category"]);

            $gender = trim($_POST["gender"]);

            $stock = trim($_POST["stock"]);

            // VALIDATION

            if (
                empty($name) ||
                empty($description) ||
                empty($price)
            ) {

                die("All fields are required");
            }

            if ($price <= 0) {

                die("Invalid Price");
            }

            if ($stock < 0) {

                die("Invalid Stock");
            }

            // IMAGE VALIDATION

            $allowed = [
                "image/jpeg",
                "image/png"
            ];

            if (
                !in_array(
                    $_FILES["image"]["type"],
                    $allowed
                )
            ) {

                die("Only JPG and PNG allowed");
            }

            if (
                $_FILES["image"]["size"] > 2000000
            ) {

                die("Image size must be below 2MB");
            }

            // IMAGE UPLOAD

            $image =
            time()
            . "_"
            . basename($_FILES["image"]["name"]);

            move_uploaded_file(
                $_FILES["image"]["tmp_name"],
                "../public/uploads/products/" . $image
            );

            // INSERT PRODUCT

            $this->product->create(
                $name,
                $description,
                $sizeChart,
                $price,
                $gender,
                $category,
                $image,
                $stock
            );

            header(
                "Location: ../views/admin_products.php?success=1"
            );
        }
    }

    // DELETE PRODUCT

    public function deleteProduct() {

        $this->checkAdmin();

        $product =
        $this->product->getById(
            $_GET["id"]
        );

        if (
            file_exists(
                "../public/uploads/products/"
                . $product["image_path"]
            )
        ) {

            unlink(
                "../public/uploads/products/"
                . $product["image_path"]
            );
        }

        $this->product->delete(
            $_GET["id"]
        );

        header(
            "Location: ../views/admin_products.php"
        );
    }

    // DELETE CUSTOMER

    public function deleteCustomer() {

        $this->checkAdmin();

        $this->customer->deleteCustomer(
            $_GET["id"]
        );

        header(
            "Location: ../views/admin_customers.php"
        );
    }

    // AJAX ORDER UPDATE

    public function updateOrder() {

        $this->checkAdmin();

        header(
            "Content-Type: application/json"
        );

        $this->order->updateStatus(
            $_POST["id"],
            $_POST["status"]
        );

        echo json_encode([
            "success" => true
        ]);
    }
}

// ROUTER

if (isset($_GET["action"])) {

    $admin = new AdminController();

    if ($_GET["action"] == "addProduct") {

        $admin->addProduct();
    }

    if ($_GET["action"] == "deleteProduct") {

        $admin->deleteProduct();
    }

    if ($_GET["action"] == "deleteCustomer") {

        $admin->deleteCustomer();
    }

    if ($_GET["action"] == "updateOrder") {

        $admin->updateOrder();
    }
}
?>