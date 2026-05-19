<?php

require_once __DIR__ . "/../config/Database.php";

class ProductController {

    private $conn;

    public function __construct() {

        $this->conn = (new Database())->connect();
    }

    // AJAX SEARCH

    public function search() {

        header(
            "Content-Type: application/json"
        );

        $q =
        $_GET["q"] ?? "";

        $gender =
        $_GET["gender"] ?? "";

        $category =
        $_GET["category"] ?? "";

        $sql = "SELECT *
                FROM products
                WHERE name LIKE ?";

        $params = ["%$q%"];

        // FILTER GENDER

        if (!empty($gender)) {

            $sql .= " AND gender=?";

            $params[] = $gender;
        }

        // FILTER CATEGORY

        if (!empty($category)) {

            $sql .= " AND category_id=?";

            $params[] = $category;
        }

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($params);

        echo json_encode(
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }
}

// ROUTER

if (isset($_GET["action"])) {

    $product = new ProductController();

    if ($_GET["action"] == "search") {

        $product->search();
    }
}
?>