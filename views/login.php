<?php include "partials_navbar.php"; ?>

<div class="form-container">

    <form
        method="POST"
        action="../controllers/AuthController.php?action=login"
    >

        <h2>
            Login
        </h2>

        <input
            type="email"
            name="email"
            placeholder="Email"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Password"
            required
        >

        <label>

            <input
                type="checkbox"
                name="remember"
            >

            Remember Me

        </label>

        <button>
            Login
        </button>

    </form>

</div>

<?php include "partials_footer.php"; ?>