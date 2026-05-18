<?php

include "partials_navbar.php";

if ($_SESSION["role"] != "admin") {

    die("Access Denied");
}

require_once "../models/Product.php";

$product = new Product();

$p = $product->getById($_GET["id"]);
?>

<div class="container">

    <h2 class="section-title">
        Edit Product
    </h2>

    <form
        class="admin-form"
        method="POST"
        enctype="multipart/form-data"
        action="../controllers/AdminController.php?action=updateProduct"
    >

        <input
            type="hidden"
            name="id"
            value="<?= $p['id'] ?>"
        >

        <input
            type="text"
            name="name"
            value="<?= htmlspecialchars($p['name']) ?>"
        >

        <textarea
            name="description"
        ><?= htmlspecialchars($p['description']) ?></textarea>

        <textarea
            name="size_chart"
        ><?= htmlspecialchars($p['size_chart']) ?></textarea>

        <input
            type="number"
            name="price"
            value="<?= $p['price'] ?>"
        >

        <input
            type="number"
            name="stock"
            value="<?= $p['stock'] ?>"
        >

        <select name="gender">

            <option value="Men">
                Men
            </option>

            <option value="Women">
                Women
            </option>

        </select>

        <input
            type="file"
            name="image"
        >

        <button>
            Update Product
        </button>

    </form>

</div>

<?php include "partials_footer.php"; ?>