<?php

include "partials_navbar.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");

    exit;
}
?>

<div class="container success-page">

    <h1>

        Order Placed Successfully

    </h1>

    <h2>

        Order ID :
        #<?= $_GET["id"] ?>

    </h2>

    <p>

        Your order has been placed
        successfully and is currently
        pending admin confirmation.

    </p>

    <a
        href="home.php"
        class="btn"
    >
        Continue Shopping
    </a>

</div>

<?php include "partials_footer.php"; ?>