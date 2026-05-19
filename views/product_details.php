<?php

include "partials_navbar.php";

require_once "../models/Product.php";

$productModel = new Product();

$product = $productModel->getById(
    $_GET["id"]
);

if (!$product) {

    die("Product not found");
}
?>

<div class="container">

    <div class="product-details">

        <img
            class="details-image"
            src="../public/uploads/products/<?= $product['image_path'] ?>"
        >

        <div class="details-content">

            <h2>
                <?= htmlspecialchars($product['name']) ?>
            </h2>

            <p>
                <?= htmlspecialchars($product['description']) ?>
            </p>

            <h3>
                Price :
                ৳<?= $product['price'] ?>
            </h3>

            <p>
                Stock :
                <?= $product['stock'] ?>
            </p>

            <p>
                Gender :
                <?= $product['gender'] ?>
            </p>

            <h4>
                Size Chart
            </h4>

            <p>
                <?= nl2br(
                    htmlspecialchars(
                        $product['size_chart']
                    )
                ) ?>
            </p>

            <?php if(isset($_SESSION["user_id"])): ?>

                <input
                    type="number"
                    id="qty"
                    value="1"
                    min="1"
                    max="<?= $product['stock'] ?>"
                >

                <button
                    class="btn"
                    onclick="addCart(
                        <?= $product['id'] ?>
                    )"
                >
                    Add To Cart
                </button>

            <?php else: ?>

                <p class="login-warning">

                    Login required to purchase

                </p>

            <?php endif; ?>

        </div>

    </div>

</div>

<script>

function addCart(product){

    let qty =
    document.getElementById("qty").value;

    fetch(
        "../controllers/CartController.php?action=add",
        {
            method: "POST",

            headers:{
                "Content-Type":
                "application/x-www-form-urlencoded"
            },

            body:
            "product_id="
            + product
            + "&quantity="
            + qty
        }
    )

    .then(res => res.json())

    .then(data => {

        if(data.success){

            alert("Added To Cart");

        }else{

            alert(data.message);
        }
    });
}

</script>

<?php include "partials_footer.php"; ?>