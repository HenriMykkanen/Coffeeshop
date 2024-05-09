<?php
session_start();
require('templates/header.php');
require('templates/navigation.php');
require('lib/class.base.php');
require('lib/class.product.php');
require('lib/class.productimage.php');
require('lib/class.cart.php');

$deliverymethod = $_POST['delivery'];
$deliverycost = $_POST['deliverycost'];

$data = array(
    'delivery_method' => $deliverymethod,
    'delivery_cost' => $deliverycost
);

$json = json_encode($data);

$_SESSION['deliverymethod'] = $json;

?>

<body>
    <section class="maincontent">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card shoppingcartcard">
                    <div class="card-body">
                        <h3 class="text-center">Choose payment method</h3>
                        <div class="container py-5 h-100">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="col-12">
                                    <div class="card" style="border-radius: 15px;">
                                        <form action="checkout.php" method="POST">
                                            <div class="card-body p-0">
                                                <div class="block-body">
                                                    <div class="row">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <div class="form-check pb-5">
                                                                <input class="form-check-input" type="radio" name="payment" value="visa" id="option0" required>
                                                                <label class="form-check-label ms-3" for="option0">
                                                                    <strong class="d-block text-uppercase mb-2">Visa</strong>
                                                                    <span class="text-muted text-sm">Pay with your Visa Card.</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <div class="form-check pb-5">
                                                                <input class="form-check-input" type="radio" name="payment" value="mastercard" id="option1">
                                                                <label class="form-check-label ms-3" for="option1">
                                                                    <strong class="d-block text-uppercase mb-2">Mastercard</strong>
                                                                    <span class="text-muted text-sm">Pay with your Mastercard.</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="payment" value="paypal" id="option2">
                                                                <label class="form-check-label ms-3 pb-5" for="option2">
                                                                    <strong class="d-block text-uppercase mb-2">PayPal</strong>
                                                                    <span class="text-muted text-sm">Pay with your PayPal account.</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="payment" value="mobilepay" id="option3">
                                                                <label class="form-check-label ms-3 pb-5" for="option3">
                                                                    <strong class="d-block text-uppercase mb-2">Mobilepay</strong>
                                                                    <span class="text-muted text-sm">Pay with your Mobilepay.</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid gap-2 mt-auto">
                                                    <button type="submit" href="checkout.php" class="btn custombutton-darktext">Continue -></A>
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
    </section>
    <?php require('templates/footer.php'); ?>
    <script></script>
</body>