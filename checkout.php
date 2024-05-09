<?php
session_start();
require('templates/header.php');
require('templates/navigation.php');
require('lib/class.base.php');
require('lib/class.product.php');
require('lib/class.productimage.php');
require('lib/class.cart.php');
require('lib/class.user.php');
require('lib/class.customer.php');
require('lib/class.admin.php');

$_SESSION['paymentmethod'] = $_POST['payment'];

$customer = new customer($_SESSION['logged_id'], $sql, 'users');
$customer->init();
$deliveryInformation = $customer->getDeliveryInformation();
$deliveryInformation = json_encode($deliveryInformation);
?>

<body onload=fetchCartContents()>
    <section class="maincontent">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card rounded shoppingcartcard">
                    <div class="card-body">
                        <h2 class="text-center">Delivery summary</h2>
                        <div class="container py-5 h-100">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="col-12">
                                    <div class="card rounded" style="border-radius: 15px;">
                                        <div class="card-body p-0">
                                            <div class="" id="displaycart">
                                                <!-- Products table will be built here with JavaScript -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card rounded deliveryinformation">
                    <div class="card-body d-flex flex-column">
                        <h4 class="pb-2" style="font-weight: 600">Delivery information:</h4>
                        <div class="row">
                            <div class="col-6">
                                <p class="fs-6">First name:</p>
                                <p class="fs-6">Last name:</p>
                                <p class="fs-6">Email:</p>
                                <p class="fs-6">Phone:</p>
                                <p class="fs-6">Street:</p>
                                <p class="fs-6">City:</p>
                                <p class="fs-6">Zip:</p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="fs-6" data-firstname></p>
                                <p class="fs-6" data-lastname></p>
                                <p class="fs-6" data-email></p>
                                <p class="fs-6" data-phone></p>
                                <p class="fs-6" data-street></p>
                                <p class="fs-6" data-city></p>
                                <p class="fs-6" data-zip></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">

                    <div class="card rounded shippingmethod">
                        <div class="card-body d-flex flex-column">
                            <h4 class="pb-2" style="font-weight: 600">Delivery method:</h4>
                            <div class="row">
                                <div class="col-6">
                                    <p class="fs-6">Chosen delivery method:</p>

                                </div>
                                <div class="col-6 text-end">
                                    <p class="fs-6" data-deliverymethod></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card rounded paymentmethod">
                        <div class="card-body d-flex flex-column">
                            <h4 class="pb-2" style="font-weight: 600">Payment method:</h4>
                            <div class="row">
                                <div class="col-6">
                                    <p class="fs-6">Chosen payment method:</p>

                                </div>
                                <div class="col-6 text-end">
                                    <p class="fs-6" data-paymentmethod></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card rounded shoppingcarttotal">
                            <div class="card-body d-flex flex-column">
                                <h4 class="pb-2" style="font-weight: 600">Total:</h4>
                                <div class="row lastbeforetotal">
                                    <div class="col-6">
                                        <p>Subtotal:</p>
                                        <p>Taxes:</p>
                                        <p>Delivery fees:</p>
                                    </div>
                                    <div class="col-6 text-end">
                                        <p data-subtotal></p>
                                        <p data-taxes></p>
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
                                    <button class="btn custombutton-darktext" type="button" id="orderbutton">Proceed to payment</button>
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
                const cartContents = myJson;

                // Get info about the order and display it on the page
                const deliveryInformation = <?php echo $deliveryInformation; ?>;
                const deliveryMethod = <?php echo $_SESSION['deliverymethod']; ?>;
                const paymentMethod = '<?php echo $_POST['payment']; ?>';


                document.querySelector('[data-firstname]').innerHTML = deliveryInformation[0].firstname;
                document.querySelector('[data-lastname]').innerHTML = deliveryInformation[0].lastname;
                document.querySelector('[data-email]').innerHTML = deliveryInformation[0].email;
                document.querySelector('[data-phone]').innerHTML = deliveryInformation[0].phone;
                document.querySelector('[data-street]').innerHTML = deliveryInformation[0].street;
                document.querySelector('[data-city]').innerHTML = deliveryInformation[0].city;
                document.querySelector('[data-zip]').innerHTML = deliveryInformation[0].zip;
                document.querySelector('[data-deliverymethod]').innerHTML = deliveryMethod.delivery_method;
                document.querySelector('[data-paymentmethod]').innerHTML = paymentMethod;

                // Calculate order price and display it
                let subTotal = 0;
                let taxAmount = 0;
                let totalPrice = 0;

                for (let i = 0; i < cartContents.length; i++) {
                    const product = cartContents[i];
                    const price = parseFloat(product.price);
                    const quantity = parseInt(product.quantity);
                    const tax = parseFloat(product.tax);

                    const subtotalCalculation = price * quantity;
                    subTotal += subtotalCalculation;
                    const totalPriceCalculation = (price * quantity) * (1 + (tax / 100));
                    totalPrice += totalPriceCalculation;
                }
                taxAmount = totalPrice - subTotal;
                totalPrice = totalPrice + parseFloat(deliveryMethod.delivery_cost);
                window.orderPriceNoTax = subTotal;
                window.orderTotalPrice = totalPrice;

                document.querySelector('[data-subtotal]').innerHTML = subTotal.toFixed(2) + '€';
                document.querySelector('[data-taxes]').innerHTML = taxAmount.toFixed(2) + '€';
                document.querySelector('[data-deliveryfees]').innerHTML = deliveryMethod.delivery_cost + '€';
                document.querySelector('[data-total]').innerHTML = totalPrice.toFixed(2) + '€';

                // Create elements for displaying the products that are being ordered
                for (let i = 0; i <= cartContents.length; i++) {


                    // Row
                    let shoppingCartRow = document.createElement('div');
                    shoppingCartRow.setAttribute('class', 'row shoppingcartrow pt-2 pb-2');

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
                    productQuantityCol.setAttribute('class', 'col-lg-12 col-md-12 col-sm-12 text-center');

                    let productPriceCol = document.createElement('div');
                    productPriceCol.setAttribute('class', 'col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center');

                    let productQuantity = document.createElement('p');
                    productQuantity.setAttribute('class', 'fs-6');
                    let currentQuantity = cartContents[i].quantity;
                    productQuantity.innerHTML = 'Quantity: ' + currentQuantity;
                    productQuantityCol.appendChild(productQuantity);

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
                }
            })
        };
        // Collect all the relevant order data into one JSON string and send it forward to make an order
        $(document).ready(function() {
            $('#orderbutton').on('click', function(e) {
                e.preventDefault();

                const deliveryMethod = <?php echo $_SESSION['deliverymethod']; ?>;
                const paymentMethod = '<?php echo $_POST['payment']; ?>';

                fetch('do_order.php', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        customerID: <?php echo $_SESSION['logged_id']; ?>,
                        orderPriceNoTax: window.orderPriceNoTax,
                        orderPriceTotal: window.orderTotalPrice,
                        deliveryMethod: deliveryMethod.delivery_method,
                        paymentMethod: paymentMethod
                    })
                }).then(function(response) {
                    window.location.href = "http://sakky.luowa.fi/henri_mykkanen/n%C3%A4ytt%C3%B6ty%C3%B6/orderconfirmation.php";
                })
            });
        });
    </script>
</body>