<?php

include "partials_navbar.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");

    exit;
}

require_once "../models/OrderCustomer.php";

$orderModel = new OrderCustomer();

$orders =
$orderModel->getOrdersByUser(
    $_SESSION["user_id"]
);
?>

<div class="container">

    <h2 class="section-title">

        Purchase History

    </h2>

    <?php foreach($orders as $order): ?>

        <div class="history-card">

            <h3>

                Order #<?= $order["id"] ?>

            </h3>

            <p>

                Status :
                <?= $order["status"] ?>

            </p>

            <p>

                Total :
                ৳<?= $order["total_amount"] ?>

            </p>

            <p>

                Date :
                <?= $order["order_date"] ?>

            </p>

            <h4>

                Products

            </h4>

            <?php

            $items =
            $orderModel->getOrderItems(
                $order["id"]
            );

            foreach($items as $item):

            ?>

                <p>

                    <?= htmlspecialchars(
                        $item["name"]
                    ) ?>

                    ×

                    <?= $item["quantity"] ?>

                    —

                    ৳<?= $item["unit_price"] ?>

                </p>

            <?php endforeach; ?>

        </div>

    <?php endforeach; ?>

</div>

<?php include "partials_footer.php"; ?>