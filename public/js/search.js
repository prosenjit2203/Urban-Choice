document.getElementById("search")
.onkeyup = function () {

    fetch(
        "../controllers/ProductController.php?action=search&q="
        + this.value
    )

    .then(res => res.json())

    .then(data => {

        let html = "";

        data.forEach(p => {

            html += `

            <div class="card">

                <img src="../public/uploads/products/${p.image_path}">

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

        document.getElementById("result").innerHTML = html;
    });
};