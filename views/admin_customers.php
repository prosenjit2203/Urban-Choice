<?php

include "partials_navbar.php";

if ($_SESSION["role"] != "admin") {

    die("Access Denied");
}

require_once "../models/AdminCustomer.php";

$customer = new AdminCustomer();

$customers = $customer->getCustomers();
?>

<div class="container">

    <h2 class="section-title">
        Customers
    </h2>

    <table class="table">

        <tr>

            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>

        </tr>

        <?php foreach($customers as $c): ?>

        <tr>

            <td><?= htmlspecialchars($c['name']) ?></td>

            <td><?= htmlspecialchars($c['email']) ?></td>

            <td><?= htmlspecialchars($c['phone']) ?></td>

            <td>

                <a
                    class="btn delete-btn"
                    href="../controllers/AdminController.php?action=deleteCustomer&id=<?= $c['id'] ?>"
                >
                    Delete
                </a>

            </td>

        </tr>

        <?php endforeach; ?>

    </table>

</div>

<?php include "partials_footer.php"; ?>