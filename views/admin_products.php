<?php

include "partials_navbar.php";

if (
    !isset($_SESSION["role"]) ||
    $_SESSION["role"] != "admin"
) {

    die("Access Denied");
}

require_once "../models/Product.php";

$product = new Product();

$products = $product->getAll();

?>

<div class="container">

    <h2 class="section-title">
        Product Management
    </h2>

    <div class="form-container">

        <form
            method="POST"
            enctype="multipart/form-data"
            action="../controllers/AdminController.php?action=addProduct"
        >

            <input
                type="text"
                name="name"
                placeholder="Product Name"
                required
            >

            <textarea
                name="description"
                placeholder="Description"
                required
            ></textarea>

            <textarea
                name="size_chart"
                placeholder="Size Chart"
            ></textarea>

            <input
                type="number"
                step="0.01"
                name="price"
                placeholder="Price"
                required
            >

            <select name="gender" required>

                <option value="">
                    Select Gender
                </option>

                <option value="Men">
                    Men
                </option>

                <option value="Women">
                    Women
                </option>

            </select>

            <input
                type="text"
                name="category"
                placeholder="Category"
                required
            >

            <input
                type="number"
                name="stock"
                placeholder="Stock"
                required
            >

            <input
                type="file"
                name="image"
                required
            >

            <button type="submit">
                Add Product
            </button>

        </form>

    </div>

    <br>

    <div class="products">

        <?php foreach($products as $p): ?>

            <div class="card">

                <img
                    src="../public/uploads/products/<?= $p['image_path'] ?>"
                >

                <h3>
                    <?= htmlspecialchars($p['name']) ?>
                </h3>

                <p>
                    ৳<?= $p['price'] ?>
                </p>

                <p>
                    <?= htmlspecialchars($p['category']) ?>
                </p>

                <a
                    class="btn delete-btn"
                    href="../controllers/AdminController.php?action=deleteProduct&id=<?= $p['id'] ?>"
                >
                    Delete
                </a>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<?php include "partials_footer.php"; ?>