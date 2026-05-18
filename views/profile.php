<?php

include "partials_navbar.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
}

require_once "../models/User.php";

$user = (new User())->findById(
    $_SESSION["user_id"]
);
?>

<div class="form-container">

    <?php if(isset($_GET["success"])): ?>

        <div class="success">

            Profile Updated Successfully

        </div>

    <?php endif; ?>

    <form
        method="POST"
        enctype="multipart/form-data"
        action="../controllers/ProfileController.php?action=update"
    >

        <h2>
            Profile
        </h2>

        <img
            class="profile-image"
            src="../public/uploads/<?= $user['profile_picture'] ?>"
        >

        <input
            type="text"
            name="name"
            value="<?= htmlspecialchars($user['name']) ?>"
        >

        <input
            type="email"
            name="email"
            value="<?= htmlspecialchars($user['email']) ?>"
        >

        <input
            type="text"
            name="address"
            value="<?= htmlspecialchars($user['address']) ?>"
        >

        <input
            type="text"
            name="phone"
            value="<?= htmlspecialchars($user['phone']) ?>"
        >

        <input
            type="file"
            name="picture"
        >

        <input
            type="password"
            name="current_password"
            placeholder="Current Password"
        >

        <input
            type="password"
            name="new_password"
            placeholder="New Password"
        >

        <button>
            Update Profile
        </button>

    </form>

    <hr>

    <a
        class="btn"
        href="purchase_history.php"
    >
        View Purchase History
    </a>

</div>

<?php include "partials_footer.php"; ?>