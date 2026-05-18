<?php

session_start();

require_once "../controllers/AuthController.php";

AuthController::autoLogin();
?>

<!DOCTYPE html>

<html>

<head>

    <title>
        Urban Choice
    </title>

    <link
        rel="stylesheet"
        href="../public/css/style.css"
    >

</head>

<body>

<nav>

    <div class="logo">
        Urban Choice
    </div>

    <div class="nav-links">

        <a href="home.php">
            Home
        </a>

        <?php if(isset($_SESSION["user_id"])): ?>

            <a href="profile.php">
                Profile
            </a>

            <a href="cart.php">Cart</a>

            <?php if($_SESSION["role"] == "admin"): ?>

                <a href="admin_dashboard.php">
                    Dashboard
                </a>

                <a href="admin_products.php">
                  Manage Products
                </a>

                <a href="purchase_history.php">
                    Purchase History
                </a>

            <?php endif; ?>

            <a href="../controllers/AuthController.php?action=logout">
                Logout
            </a>

        <?php else: ?>

            <a href="login.php">
                Login
            </a>

            <a href="register.php">
                Register
            </a>

        <?php endif; ?>

    </div>

</nav>