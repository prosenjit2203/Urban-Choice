<h2 class="section-title">
    Search Products
</h2>

<div class="search-box">

    <input
        type="text"
        id="search"
        placeholder="Search Fashion Products..."
    >

    <select id="gender">

        <option value="">
            All Gender
        </option>

        <option value="Men">
            Men
        </option>

        <option value="Women">
            Women
        </option>

    </select>

    <select id="category">

        <option value="">
            All Categories
        </option>

        <option value="1">
            Shirts
        </option>

        <option value="2">
            Pants
        </option>

        <option value="3">
            Salwar
        </option>

        <option value="4">
            Jeans
        </option>

    </select>

</div>

<div
    id="result"
    class="products"
></div>

<script>

function loadProducts(){

    let q =
    document.getElementById("search").value;

    let gender =
    document.getElementById("gender").value;

    let category =
    document.getElementById("category").value;

    fetch(
        "../controllers/ProductController.php?action=search&q="
        + q
        + "&gender="
        + gender
        + "&category="
        + category
    )

    .then(res => res.json())

    .then(data => {

        let html = "";

        data.forEach(p => {

            html += `

            <div class="card">

                <img
                    src="../public/uploads/products/${p.image_path}"
                >

                <h3>${p.name}</h3>

                <p>৳${p.price}</p>

                <a
                    class="btn"
                    href="product_details.php?id=${p.id}"
                >
                    View Product
                </a>

            </div>

            `;
        });

        document.getElementById(
            "result"
        ).innerHTML = html;
    });
}

document.getElementById(
    "search"
).onkeyup = loadProducts;

document.getElementById(
    "gender"
).onchange = loadProducts;

document.getElementById(
    "category"
).onchange = loadProducts;

loadProducts();

</script>