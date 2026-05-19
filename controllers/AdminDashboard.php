<?php
require_once __DIR__ . "/../config/Database.php";

class AdminDashboard {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function getCounts() {
        $data = [];

        $data['products'] = $this->conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
        $data['customers'] = $this->conn->query("SELECT COUNT(*) FROM users WHERE role='customer'")->fetchColumn();
        $data['orders'] = $this->conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        $data['pending'] = $this->conn->query("SELECT COUNT(*) FROM orders WHERE status='pending'")->fetchColumn();

        return $data;
    }
}