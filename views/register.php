<?php include "partials_navbar.php"; ?>

<div class="form-container">

    <form
        method="POST"
        enctype="multipart/form-data"
        action="../controllers/AuthController.php?action=register"
        onsubmit="return validateRegister()"
    >

        <h2>
            Register
        </h2>

        <input
            type="text"
            name="name"
            id="name"
            placeholder="Full Name"
            required
        >

        <input
            type="email"
            name="email"
            id="email"
            placeholder="Email"
            required
        >

        <input
            type="password"
            name="password"
            id="password"
            placeholder="Password"
            required
        >

        <select name="role">

            <option value="customer">
                Customer
            </option>

            <option value="admin">
                Admin
            </option>

        </select>

        <input
            type="text"
            name="address"
            placeholder="Address"
            required
        >

        <input
            type="text"
            name="phone"
            placeholder="Phone"
            required
        >

        <input
            type="file"
            name="picture"
        >

        <button>
            Register
        </button>

    </form>

</div>

<script>

function validateRegister(){

    let password =
    document.getElementById("password").value;

    if(password.length < 8){

        alert(
            "Password must be 8 characters"
        );

        return false;
    }

    return true;
}

</script>

<?php include "partials_footer.php"; ?>