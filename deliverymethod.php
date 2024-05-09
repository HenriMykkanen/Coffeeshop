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

?>

<body onload=getDeliveryCost()>
    <section class="maincontent">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card rounded shoppingcartcard">
                    <div class="card-body">
                        <h3 class="text-center">Choose delivery method</h3>
                        <div class="container py-5 h-100">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="col-12">
                                    <div class="card" style="border-radius: 15px;">
                                        <form action="paymentmethod.php" method="POST">
                                            <div class="card-body p-0">
                                                <div class="block-body">
                                                    <div class="row">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <div class="form-check pb-5">
                                                                <input class="form-check-input" type="radio" name="delivery" value="USPS Next Day" data-deliverycost="15" id="option0" required>
                                                                <label class="form-check-label ms-3" for="option0">
                                                                    <strong class="d-block text-uppercase mb-2">USPS Next Day 15€</strong>
                                                                    <span class="text-muted text-sm">Get it right on the next day.</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <div class="form-check pb-5">
                                                                <input class="form-check-input" type="radio" name="delivery" value="USPS Priority Mail" data-deliverycost="10" id="option1">
                                                                <label class="form-check-label ms-3" for="option1">
                                                                    <strong class="d-block text-uppercase mb-2">USPS Priority Mail 10€</strong>
                                                                    <span class="text-muted text-sm">Delivery in 1-3 business days.</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="delivery" value="USPS First Class Mail" data-deliverycost="7" id="option2">
                                                                <label class="form-check-label ms-3 pb-5" for="option2">
                                                                    <strong class="d-block text-uppercase mb-2">USPS First Class Mail 7€</strong>
                                                                    <span class="text-muted text-sm">Delivery in 2-3 business days.</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="delivery" value="USPS Media Mail" data-deliverycost="5" id="option3">
                                                                <label class="form-check-label ms-3 pb-5" for="option3">
                                                                    <strong class="d-block text-uppercase mb-2">USPS Media Mail 5€</strong>
                                                                    <span class="text-muted text-sm">Delivery in 2-8 business days.</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-grid gap-2 mt-auto">
                                                        <input type="hidden" name="deliverycost" id="deliverycost" value="">
                                                        <button type="submit" href="paymentmethod.php" class="btn custombutton-darktext">Continue -></button>
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php require('templates/footer.php'); ?>
    <script>
        // Adds an event listener to each radio button so that deliverycost can be sent in a hidden input field
        function getDeliveryCost() {
            document.querySelectorAll('input[type=radio][name="delivery"]')
                .forEach(radio => {
                    radio.addEventListener('change', (event) => {
                        document.getElementById('deliverycost').value = event.target.dataset.deliverycost;
                    });
                });
        }
    </script>
</body>