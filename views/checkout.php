<?php

include "partials_navbar.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");

    exit;
}

require_once "../models/Cart.php";

$cartModel = new Cart();

$items = $cartModel->getByUser(
    $_SESSION["user_id"]
);

if (count($items) == 0) {

    die("Cart Empty");
}

$total = 0;
?>

<div class="container">

    <h2 class="section-title">

        Checkout Invoice

    </h2>

    <table class="table">

        <tr>

            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>

        </tr>

        <?php foreach($items as $item): ?>

        <?php

        $subtotal =
        $item["price"]
        * $item["quantity"];

        $total += $subtotal;

        ?>

        <tr>

            <td>
                <?= htmlspecialchars(
                    $item["name"]
                ) ?>
            </td>

            <td>
                ৳<?= $item["price"] ?>
            </td>

            <td>
                <?= $item["quantity"] ?>
            </td>

            <td>
                ৳<?= $subtotal ?>
            </td>

        </tr>

        <?php endforeach; ?>

    </table>

    <h3>

        Total :
        ৳<?= $total ?>

    </h3>

    <form
        method="POST"
        action="../controllers/OrderController.php?action=checkout"
        id="checkoutForm"
    >

        <label>

            Select Payment Method

        </label>

        <select
            name="payment_method"
            id="payment_method"
        >

            <option value="">
                Select
            </option>

            <option value="Credit Card">
                Credit Card
            </option>

            <option value="bKash">
                bKash
            </option>

            <option value="Nagad">
                Nagad
            </option>

            <option value="Bank Transfer">
                Bank Transfer
            </option>

            <option value="Cash on Delivery">
                Cash on Delivery
            </option>

        </select>

        <br><br>

        <a
            href="cart.php"
            class="btn danger-btn"
        >
            Cancel
        </a>

        <button
            type="submit"
            class="btn"
        >
            Continue
        </button>

    </form>

</div>

<script>

document
.getElementById("checkoutForm")

.addEventListener("submit",

function(e){

    let payment =
    document.getElementById(
        "payment_method"
    ).value;

    if(payment === ""){

        e.preventDefault();

        alert(
            "Select Payment Method"
        );
    }
});

</script>

<?php include "partials_footer.php"; ?>