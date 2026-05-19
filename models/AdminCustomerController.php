<?php
session_start();
require_once __DIR__ . "/../config/Database.php";

if ($_SESSION['role'] !== 'admin') {
    header("Location: /login.php");
    exit();
}

class AdminCustomerController {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function getAllCustomers() {
        $stmt = $this->conn->prepare("SELECT id,name,email,phone,created_at FROM users WHERE role='customer'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteCustomer($id) {
        // delete cart
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE user_id=?");
        $stmt->execute([$id]);

        // delete orders & items
        $stmt = $this->conn->prepare("SELECT id FROM orders WHERE user_id=?");
        $stmt->execute([$id]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($orders as $order) {
            $this->conn->prepare("DELETE FROM order_items WHERE order_id=?")->execute([$order['id']]);
            $this->conn->prepare("DELETE FROM payments WHERE order_id=?")->execute([$order['id']]);
        }

        $this->conn->prepare("DELETE FROM orders WHERE user_id=?")->execute([$id]);

        // delete user
        $this->conn->prepare("DELETE FROM users WHERE id=?")->execute([$id]);

        header("Location: /views/admin/customers.php");
    }
}

$controller = new AdminCustomerController();

if(isset($_GET['delete'])){
    $controller->deleteCustomer($_GET['delete']);
}