<?php

include "partials_navbar.php";

require_once "../config/Database.php";

$conn = (new Database())->connect();

$gender = $_GET["gender"] ?? "";

$stmt = $conn->prepare(
    "SELECT * FROM products
    WHERE gender=?"
);

$stmt->execute([$gender]);

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">

    <h2 class="section-title">

        <?= htmlspecialchars($gender) ?>

        Collection

    </h2>

    <div class="products">

        <?php foreach($products as $p): ?>

            <div class="card">

                <img
                    src="../public/uploads/products/<?= $p['image_path'] ?>"
                >

                <h3>
                    <?= htmlspecialchars($p['name']) ?>
                </h3>

                <p>
                    ৳<?= $p['price'] ?>
                </p>

                <a
                    class="btn"
                    href="product_details.php?id=<?= $p['id'] ?>"
                >
                    View Product
                </a>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<?php include "partials_footer.php"; ?>