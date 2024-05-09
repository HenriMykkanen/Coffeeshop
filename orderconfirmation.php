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

<body onload=fetchCartContents()>
    <section class="maincontent">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card shoppingcartcard">
                    <div class="card-body">
                        <div class="container py-5 h-100">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="col-12">
                                    <div class="card" style="border-radius: 15px;">
                                        <div class="card-body text-center p-0">
                                            <h1 class="fw-bolder pb-5">THANK YOU!</h1>
                                            <p class="fs-6">We have received your order and sent you an confirmation email.</p>
                                            <p class="fs-6">Please allow us up to 2 business days (excluding weekends, holidays, and sale days) to process and ship your order.</p>
                                            <p class="fs-6">You will receive another email when your order has shipped.</p>
                                            <a href="catalog.php" class="btn custombutton-darktext">
                                                Continue exploring
                                                <i class="fas fa-arrow-right ml-2"></i>
                                            </a>

                                        </div>
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
    <script></script>
</body>