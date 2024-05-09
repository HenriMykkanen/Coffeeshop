<?php
session_start();
require('templates/header.php');
require('templates/navigation.php');
require('lib/class.base.php');
require('lib/class.product.php');
require('lib/class.productimage.php');
require('lib/class.cart.php');
?>

<body onload=fetchCartContents()>
    <section class="maincontent">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="card rounded shoppingcartcard">
                        <div class="card-body" id="displaysuggestions">
                            <h2>Shopping cart:</h2>
                            <div class="container" id="displaycart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <div class="card rounded shoppingcarttotal">
                        <div class="card-body d-flex flex-column">
                            <h4 class="pb-2" style="font-weight: 600">Total:</h4>
                            <div class="row lastbeforetotal">
                                <div class="col-6">
                                    <p>Subtotal:</p>
                                    <p>Delivery fees:</p>
                                </div>
                                <div class="col-6 text-end">
                                    <p data-subtotal></p>
                                    <p data-deliveryfees></p>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-6">
                                    <p>Total:</p>
                                </div>
                                <div class="col-6 text-end">
                                    <p data-total></p>
                                </div>
                            </div>
                            <div class="d-grid gap-2 mt-auto">
                                <a href="deliveryinformation.php" id="moveToCheckoutButton" class="btn custombutton-darktext" type="button">Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php require('templates/footer.php'); ?>
    <script>
        fetchCartContents = function() {
            fetch('fetchCartContents.php').then(function(response) {
                return response.json();
            }).then(function(myJson) {
                // Check for empty JSON
                if (Object.keys(myJson).length === 0) {
                    console.log('The JSON object is empty.');
                    // Initiate another fetch call that will suggest products to the customer
                    fetchProductsAndImages();
                } else {
                    buildCartView(myJson);
                }
            })
        }

        fetchProductsAndImages = function() {
            fetch('fetchproductsandimages.php').then(function(response) {
                return response.json();
            }).then(function(myJson) {
                suggestProducts(myJson);
                calculateTotalPrice();
            })
        }

        // Generates a html template containing 4 random product suggestions
        function suggestProducts(productsJSON) {

            const allProducts = productsJSON;
            const randomProducts = [];

            // Uses math random to pick 4 random products from all of the products
            while (randomProducts.length < 4) {
                const randomIndex = Math.floor(Math.random() * allProducts.length);
                const randomProduct = allProducts[randomIndex];

                if (!randomProducts.includes(randomProduct)) {
                    randomProducts.push(randomProduct);
                }
            }

            const suggestionsTemplate = /*html*/
                `<h3>It seems your shopping cart is empty</h3>
                <p class="fs-6">Here are some suggestions to satisfy your coffee needs:</p>
                <div class="row">
                ${randomProducts.map(product => /*html*/ `
                <div class="col-lg-3 col-md-6 d-flex align-items-stretch text-center">
                    <div class="card rounded mb-4 box-shadow">
                        <img class="card-img-top" src="${product.imagelinks[0].imagelink}" alt="${product.name}">
                        
                        <div class="card-body d-flex flex-column justify-content-between">
                            <p class="card-title fs-6">${product.name}</p>
                            <p class="card-text fs-6 fw-bold mb-0">${product.price}€</p>
                            <div class="">
                                <div class="btn-group">
                                    <a href="product.php?productid=${product.id}" class="btn btn-sm custombutton-darktext">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `).join('')}
                </div>
                `;
            let targetdiv = document.getElementById('displaysuggestions');
            targetdiv.innerHTML = suggestionsTemplate;

        }

        function buildCartView(cartContents) {
            for (let i = 0; i <= cartContents.length; i++) {


                // Row
                let shoppingCartRow = document.createElement('div');
                shoppingCartRow.setAttribute('class', 'row shoppingcartrow pb-2');

                // Delete button
                let deleteButton = document.createElement('button');
                deleteButton.setAttribute('class', 'btn');
                deleteButton.setAttribute('onclick', 'deleteProductFromCart()');
                deleteButton.setAttribute('id', 'deletebutton');
                deleteButton.setAttribute('data-id', cartContents[i].cart_id);

                let deleteButtonIcon = document.createElement('i');
                deleteButtonIcon.setAttribute('class', 'fas fa-times');
                deleteButton.appendChild(deleteButtonIcon);

                let productDeleteButtonCol = document.createElement('div');
                productDeleteButtonCol.setAttribute('class', 'col-lg-12 text-end deletebuttoncol d-flex flex-row-reverse align-items-center');
                productDeleteButtonCol.appendChild(deleteButton);
                shoppingCartRow.appendChild(productDeleteButtonCol);

                // Image
                let productImageCol = document.createElement('div');
                productImageCol.setAttribute('class', 'col-lg-2 col-md-2 col-sm-2 col-xs-12 align-items-center d-flex');

                let productImage = document.createElement('img');
                productImage.setAttribute('class', 'productimageincart img-fluid mx-auto');
                productImage.src = cartContents[i].imagelinks[0];
                productImageCol.appendChild(productImage);
                shoppingCartRow.appendChild(productImageCol);

                // Name and description
                let productNameCol = document.createElement('div');
                productNameCol.setAttribute('class', 'col-lg-8 col-md-8 col-sm-8 col-xs-8 d-flex justify-content-center align-items-center');

                let productName = document.createElement('p');
                productName.setAttribute('class', 'productnameincart');
                productName.innerHTML = cartContents[i].name;
                productNameCol.appendChild(productName);
                shoppingCartRow.appendChild(productNameCol);

                // Quantity and price
                let productQuantityAndPriceCol = document.createElement('div');
                productQuantityAndPriceCol.setAttribute('class', 'col-lg-2 col-md-2 col-sm-2 col-xs-2 align-items-center justify-content-center d-flex ');

                shoppingCartRow.appendChild(productQuantityAndPriceCol);

                let productQuantityAndPriceDiv = document.createElement('div');
                productQuantityAndPriceDiv.setAttribute('class', 'row');

                let productQuantityCol = document.createElement('div');
                productQuantityCol.setAttribute('class', 'col-lg-12 col-md-12 col-sm-12');

                let productPriceCol = document.createElement('div');
                productPriceCol.setAttribute('class', 'col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center');

                let productQuantitySelect = document.createElement('select');
                productQuantitySelect.setAttribute('class', 'form-select');
                productQuantitySelect.setAttribute('id', 'productQuantitySelection');
                productQuantitySelect.setAttribute('data-id', cartContents[i].product_id);
                productQuantitySelect.addEventListener("change", (event) => {
                    const selectedProductsID = event.target.getAttribute('data-id');
                    const selectedQuantity = event.target.value;
                    updatePrice(selectedProductsID, cartContents[i].price, selectedQuantity);
                    updateCart(selectedProductsID, selectedQuantity);
                    calculateTotalPrice();
                });
                let maxQuantity = 5;
                let currentQuantity = cartContents[i].quantity;
                for (let y = 1; y <= maxQuantity; y++) {
                    let option = document.createElement('option');
                    option.value = y;
                    option.setAttribute('data-quantity', y);
                    option.innerHTML = y;
                    if (currentQuantity == y) {
                        option.setAttribute('selected', 'selected');
                    }
                    productQuantitySelect.appendChild(option);
                    productQuantityCol.appendChild(productQuantitySelect);
                }

                // Calculate displayed price once in the beginning
                let calculatedPrice = cartContents[i].price * cartContents[i].quantity;

                // Price
                let productPrice = document.createElement('p');
                productPrice.setAttribute('class', 'productpriceincart pt-2');
                productPrice.setAttribute('id', 'productpriceincart');
                productPrice.setAttribute('data-productprice', cartContents[i].product_id);
                productPrice.innerHTML = calculatedPrice + '€';
                productPriceCol.appendChild(productPrice);

                productQuantityAndPriceDiv.appendChild(productQuantityCol);
                productQuantityAndPriceDiv.appendChild(productPriceCol);
                productQuantityAndPriceCol.appendChild(productQuantityAndPriceDiv);

                // Display the produced elements
                let targetdiv = document.getElementById('displaycart');
                targetdiv.appendChild(shoppingCartRow);
                calculateTotalPrice();
            }
        }

        // Change the displayed price in the shopping cart to accurately represent the current value
        function updatePrice(id, price, quantity) {

            let newPrice = price * quantity;
            let productID = id;

            targetElement = document.querySelector(`[data-productprice="${productID}"`);
            targetElement.innerHTML = newPrice.toFixed(2) + '€';

        }

        function calculateTotalPrice() {
            let subtotal = 0;
            const products = document.querySelectorAll('#productpriceincart');
            products.forEach(product => {
                subtotal += parseFloat(product.textContent);
            });
            let subtotaltarget = document.querySelector('[data-subtotal]');
            subtotaltarget.innerHTML = subtotal.toFixed(2) + '€';

            let deliveryFees = 0; // modify when you add delivery fees
            let deliveryFeesTarget = document.querySelector('[data-deliveryfees]');
            deliveryFeesTarget.innerHTML = deliveryFees + '€';

            let total = subtotal + deliveryFees;
            let totaltarget = document.querySelector('[data-total]');
            totaltarget.innerHTML = total.toFixed(2) + '€';
        }

        function updateCart(productID, productQuantity) {

            $.ajax({
                type: "POST",
                url: "/henri_mykkanen/näyttötyö/ajax/updateCart.php",
                data: {
                    id: productID,
                    quantity: productQuantity,
                    requestType: 'updateCart'
                },
                dataType: "json",
                encode: true,
            }).done(function(data) {
                console.log(data);
            });
        };

        // Delete item from cart
        $(document).on("click", '#deletebutton', function(event) {

            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "/henri_mykkanen/näyttötyö/ajax/deleteProductFromCart.php",
                data: {
                    id: id,
                    requestType: 'deleteFromCart'
                },
                dataType: "json",
                encode: true,
            }).done(function(data) {
                let targetdiv = document.getElementById('displaycart');
                targetdiv.innerHTML = "";
                fetchCartContents();
                fetchCartItemCount();
            });
        });
    </script>
</body>