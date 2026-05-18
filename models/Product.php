<?php

require_once __DIR__ . "/../config/Database.php";

class Product {

    private $conn;

    public function __construct() {

        $this->conn = (new Database())->connect();
    }

    // CREATE PRODUCT

    public function create(
    $name,
    $desc,
    $sizeChart,
    $price,
    $category,
    $gender,
    $image,
    $stock
) {

    $sql = "INSERT INTO products
    (
        name,
        description,
        size_chart,
        price,
        category_id,
        gender,
        image_path,
        stock
    )

    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
        $name,
        $desc,
        $sizeChart,
        $price,
        $category,
        $gender,
        $image,
        $stock
    ]);
}

    // GET ALL PRODUCTS

    public function getAll() {

        $sql = "SELECT *
        FROM products
        ORDER BY id DESC";

        return $this->conn
        ->query($sql)
        ->fetchAll(PDO::FETCH_ASSOC);
    }

    // GET SINGLE PRODUCT

    public function getById($id) {

        $stmt = $this->conn->prepare(
            "SELECT * FROM products WHERE id=?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE PRODUCT

    public function update(
        $id,
        $name,
        $description,
        $size_chart,
        $price,
        $category,
        $gender,
        $image,
        $stock
    ) {

        $sql = "UPDATE products
        SET
            name=?,
            description=?,
            size_chart=?,
            price=?,
            category_id=?,
            gender=?,
            image_path=?,
            stock=?
        WHERE id=?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $name,
            $description,
            $size_chart,
            $price,
            $category,
            $gender,
            $image,
            $stock,
            $id
        ]);
    }

    // DELETE PRODUCT

    public function delete($id) {

        $stmt = $this->conn->prepare(
            "DELETE FROM products WHERE id=?"
        );

        return $stmt->execute([$id]);
    }

    // DASHBOARD COUNT

    public function totalProducts() {

        return $this->conn
        ->query("SELECT COUNT(*) FROM products")
        ->fetchColumn();
    }
}
?>