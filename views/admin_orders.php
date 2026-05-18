<?php

include "partials_navbar.php";

if ($_SESSION["role"] != "admin") {

    die("Access Denied");
}

require_once "../models/OrderAdmin.php";

$order = new OrderAdmin();

$orders = $order->getAllOrders();
?>

<div class="container">

    <h2 class="section-title">
        Orders
    </h2>

    <table class="table">

        <tr>

            <th>ID</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>

        </tr>

        <?php foreach($orders as $o): ?>

        <tr id="row<?= $o['id'] ?>">

            <td><?= $o['id'] ?></td>

            <td><?= htmlspecialchars($o['customer_name']) ?></td>

            <td>৳<?= $o['total_amount'] ?></td>

            <td id="status<?= $o['id'] ?>">
                <?= $o['status'] ?>
            </td>

            <td><?= $o['order_date'] ?></td>

            <td>

                <button
                    onclick="updateOrder(
                        <?= $o['id'] ?>,
                        'confirmed'
                    )"
                >
                    Confirm
                </button>

                <button
                    onclick="updateOrder(
                        <?= $o['id'] ?>,
                        'rejected'
                    )"
                >
                    Reject
                </button>

            </td>

        </tr>

        <?php endforeach; ?>

    </table>

</div>

<script>

function updateOrder(id, status){

    fetch(
        "../controllers/AdminController.php?action=updateOrder",
        {
            method: "POST",

            headers:{
                "Content-Type":
                "application/x-www-form-urlencoded"
            },

            body:
            "id="
            + id
            + "&status="
            + status
        }
    )

    .then(res => res.json())

    .then(data => {

        document.getElementById(
            "status" + id
        ).innerHTML = status;
    });
}

</script>

<?php include "partials_footer.php"; ?>