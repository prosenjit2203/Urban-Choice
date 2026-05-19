<?php
session_start();
require_once "../../config/Database.php";

if ($_SESSION['role'] !== 'admin') {
    header("Location: /login.php");
    exit();
}

$conn = (new Database())->connect();

$stmt = $conn->prepare("
    SELECT users.name, orders.id AS order_id, orders.total_amount, orders.status, orders.order_date
    FROM orders
    JOIN users ON orders.user_id = users.id
    ORDER BY orders.order_date DESC
");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>All Purchase History</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Customer</th>
    <th>Order ID</th>
    <th>Total</th>
    <th>Status</th>
    <th>Date</th>
</tr>

<?php foreach($orders as $o): ?>
<tr>
    <td><?= $o['name'] ?></td>
    <td>#<?= $o['order_id'] ?></td>
    <td>$<?= $o['total_amount'] ?></td>
    <td><?= $o['status'] ?></td>
    <td><?= $o['order_date'] ?></td>
</tr>
<?php endforeach; ?>
</table>

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
