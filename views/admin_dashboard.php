<?php

include "partials_navbar.php";

if ($_SESSION["role"] != "admin") {

    die("Access Denied");
}

require_once "../models/Product.php";
require_once "../models/AdminCustomer.php";
require_once "../models/OrderAdmin.php";

$product = new Product();
$customer = new AdminCustomer();
$order = new OrderAdmin();
?>

<div class="container">

    <h2 class="section-title">
        Admin Dashboard
    </h2>

    <div class="dashboard-grid">

        <div class="dashboard-card">
            <h3>Total Products</h3>
            <p><?= $product->totalProducts() ?></p>
        </div>

        <div class="dashboard-card">
            <h3>Total Customers</h3>
            <p><?= $customer->totalCustomers() ?></p>
        </div>

        <div class="dashboard-card">
            <h3>Total Orders</h3>
            <p><?= $order->totalOrders() ?></p>
        </div>

        <div class="dashboard-card">
            <h3>Pending Orders</h3>
            <p><?= $order->pendingOrders() ?></p>
        </div>

    </div>

</div>

<?php include "partials_footer.php"; ?>