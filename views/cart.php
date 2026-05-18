<?php

include "partials_navbar.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
}

require_once "../models/Cart.php";

$cartModel = new Cart();

$items = $cartModel->getByUser(
    $_SESSION["user_id"]
);

$total = 0;
?>

<div class="container">

    <h2 class="section-title">
        Shopping Cart
    </h2>

    <table class="table">

        <tr>

            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Action</th>

        </tr>

        <?php foreach($items as $item): ?>

        <?php
            $subtotal =
            $item['price']
            * $item['quantity'];

            $total += $subtotal;
        ?>

        <tr id="row<?= $item['id'] ?>">

            <td>

                <?= htmlspecialchars($item['name']) ?>

            </td>

            <td>

                ৳<?= $item['price'] ?>

            </td>

            <td>

                <input
                    type="number"
                    value="<?= $item['quantity'] ?>"
                    min="1"
                    onchange="updateQty(
                        <?= $item['id'] ?>,
                        this.value
                    )"
                >

            </td>

            <td>

                ৳<?= $subtotal ?>

            </td>

            <td>

                <button
                    onclick="removeItem(
                        <?= $item['id'] ?>
                    )"
                >
                    Remove
                </button>

            </td>

        </tr>

        <?php endforeach; ?>

    </table>

    <h3>
        Total :
        ৳<?= $total ?>
    </h3>

    <?php if($total > 0): ?>

        <a
            class="btn"
            href="checkout.php"
        >
            Proceed To Checkout
        </a>

    <?php endif; ?>

</div>

<script>

function updateQty(id, qty){

    fetch(
        "../controllers/CartController.php?action=update",
        {
            method: "POST",

            headers:{
                "Content-Type":
                "application/x-www-form-urlencoded"
            },

            body:
            "id="
            + id
            + "&quantity="
            + qty
        }
    )

    .then(res => res.json())

    .then(data => {

        if(data.success){

            location.reload();
        }
    });
}

function removeItem(id){

    fetch(
        "../controllers/CartController.php?action=delete",
        {
            method: "POST",

            headers:{
                "Content-Type":
                "application/x-www-form-urlencoded"
            },

            body:
            "id=" + id
        }
    )

    .then(res => res.json())

    .then(data => {

        if(data.success){

            document.getElementById(
                "row" + id
            ).remove();

            location.reload();
        }
    });
}

</script>

<?php include "partials_footer.php"; ?>