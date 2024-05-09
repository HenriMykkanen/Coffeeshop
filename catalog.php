<?php
require('templates/header.php');
require('templates/navigation.php');
require('lib/class.base.php');
require('lib/class.product.php');
require('lib/class.productimage.php');
session_start();
?>

<body onload="getCategory()">
    <section class="maincontent">
        <div class="container">
            <div class="card rounded">
                <div class="row p-3">
                    <div class="col-12 text-align-left" id="catalognav">
                        <a href="catalog.php?category=allproducts" class="fs-6 text-secondary">All products</a>
                    </div>
                </div>
                <div class="card-body">
                    <h3 class="text-center" id="categoryname"></h3>
                    <div id="targetdiv"></div>
                </div>
            </div>
        </div>
    </section>
    <?php require('templates/footer.php'); ?>
    <script>
        function buildProductCatalog(productsJSON) {

            const products = productsJSON;
            const productsTemplate = /*html*/ `
            <div class="row">
                ${products.map(product => /*html*/ `
                <div class="col-md-6 col-lg-4 col-xl-3 pb-3 d-flex align-items-stretch">
                    <div class="card rounded productcatalogcard">
                        <img class="card-img-top productcatalogimage" src="${product.imagelinks[0].imagelink}" alt="${product.name}"><img>
                        <div class="card-body text-center">
                            <p class="card-title fs-6">${product.name}</p>
                            <p class="card-text fs-6 fw-bold">${product.price}€</p>
                             <div class="btn-group">
                                <a href="product.php?productid=${product.id}" class="btn btn-sm custombutton-darktext">View</a>
                                <button type="button" class="btn btn-sm custombutton-darktext addtocartbutton" data-id="${product.id}">Add to cart</button>
                             </div>
                         </div>
                    </div>
                 </div>
                 `).join('')}
            </div>
            `;
            const targetdiv = document.getElementById('targetdiv');
            targetdiv.innerHTML = productsTemplate;

            const addToCartButtons = document.querySelectorAll('.addtocartbutton');
            addToCartButtons.forEach(button => {
                button.addEventListener("click", addToCart);
            });

        }

        function addToCart() {

            let productID = event.target.dataset.id;
            $.ajax({
                type: "POST",
                url: "/henri_mykkanen/näyttötyö/ajax/addProductToCart.php",
                data: {
                    id: productID,
                    requestType: 'addProductToCart'
                },
                dataType: "json",
                encode: true,
            }).done(function(data) {
                fetchCartItemCount();
            });
        }

        fetchAllProducts = function() {
            fetch('fetchproductsandimages.php').then(function(response) {
                return response.json();
            }).then(function(myJson) {

                buildProductCatalog(myJson);

            })
        }

        fetchProductsFromCategory = function(category_id) {

            fetch('fetchProductsFromCategory.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        category_id
                    }),
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(myJson) {
                    buildProductCatalog(myJson);
                })
        }

        getCategory = function() {

            const urlParams = new URLSearchParams(window.location.search);
            let category = urlParams.get('category');
            if (category == 'coffeebeans') {
                fetchProductsFromCategory(1);

                const categoryNameElement = document.getElementById('categoryname');
                categoryNameElement.innerHTML = 'Coffee Beans';

                const catalognav = document.getElementById('catalognav');
                catalognav.innerHTML += /*html*/ `<a href="catalog.php?category=coffeebeans" class="fs-6 text-secondary">/ Coffee Beans</a> `;
            }
            
            if (category == 'coffeemachines') {
                fetchProductsFromCategory(2);

                const categoryNameElement = document.getElementById('categoryname');
                categoryNameElement.innerHTML = 'Coffee Machines';

                const catalognav = document.getElementById('catalognav');
                catalognav.innerHTML += /*html*/ `<a href="catalog.php?category=coffeemachines" class="fs-6 text-secondary">/ Coffee Machines</a> `;
            }
            if (category == 'allproducts' || !category) {
                fetchAllProducts();

                const categoryNameElement = document.getElementById('categoryname');
                categoryNameElement.innerHTML = 'All products';

            }
        }
    </script>
</body>