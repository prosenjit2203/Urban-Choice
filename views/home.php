<?php

include "partials_navbar.php";

require_once "../config/Database.php";

$conn = (new Database())->connect();

// FEATURED PRODUCTS

$products = $conn->query(
    "SELECT * FROM products
    ORDER BY id DESC
    LIMIT 6"
)->fetchAll(PDO::FETCH_ASSOC);
?>

<header class="hero">

    <h1>
        Urban Choice
    </h1>

    <p>
        Modern Fashion Collection
    </p>

</header>

<div class="container">

    <?php include "home_intro.php"; ?>

    <!-- GENDER NAVIGATION -->

    <div class="gender-nav">

        <a href="products.php?gender=Men">
            Men
        </a>

        <a href="products.php?gender=Women">
            Women
        </a>

    </div>

    <!-- SEARCH -->

    <?php include "home_product_search.php"; ?>

    <!-- FEATURED -->

    <h2 class="section-title">
        Featured Products
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