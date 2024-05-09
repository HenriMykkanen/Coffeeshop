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

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    header("Location: deliverymethod.php");
    exit();
 }
?>

<body>
    <section class="maincontent">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card rounded shoppingcartcard">
                    <div class="card-body">
                        <h3 class="text-center">Delivery information</h3>
                        <p class="fs-6 pt-2 text-center">Once you register you will automatically be logged in.</p>
                        <div class="container py-5 h-100">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="col-12">
                                    <form method="POST" action="do_register.php">
                                        <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                                            <div class="card-body p-0">
                                                <div class="row g-0">
                                                    <div class="col-lg-6 text-white personalinfocolumn">
                                                        <div class="p-5">
                                                            <h3 class="fw-normal mb-5 text-white">Personal information</h3>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-4 pb-2">

                                                                    <div class="form-outline">
                                                                        <input type="text" id="firstnameform" name="firstname" class="form-control form-control-lg" required />
                                                                        <label class="form-label" for="firstnameform">First name</label>
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-6 mb-4 pb-2">

                                                                    <div class="form-outline">
                                                                        <input type="text" id="lastnameform" name="lastname" class="form-control form-control-lg" required />
                                                                        <label class="form-label" for="lastnameform">Last name</label>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="mb-4 pb-2">
                                                                <div class="form-outline">
                                                                    <input type="email" id="emailform" name="email" class="form-control form-control-lg" required />
                                                                    <label class="form-label" for="emailform">Email</label>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 mb-4 pb-2 mb-md-0 pb-md-0">

                                                                    <div class="form-outline">
                                                                        <input type="tel" id="phonenumberform" name="phone" class="form-control form-control-lg" required />
                                                                        <label class="form-label" for="phonenumberform">Phone number</label>
                                                                    </div>

                                                                </div>

                                                                <div class="col-md-6 mb-4 pb-2 mb-md-0 pb-md-0">

                                                                    <div class="form-outline">
                                                                        <input type="password" id="passwordform" name="password" class="form-control form-control-lg" required />
                                                                        <label class="form-label" for="passwordform">Password</label>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 text-white addresscolumn">
                                                        <div class="p-5">
                                                            <h3 class="fw-normal mb-5">Contact Details</h3>

                                                            <div class="mb-4 pb-2">
                                                                <div class="form-outline form-white">
                                                                    <input type="text" id="streetform" name="street" class="form-control form-control-lg" required />
                                                                    <label class="form-label" for="streetform">Street + Nr</label>
                                                                </div>
                                                            </div>

                                                            <div class="row">

                                                                <div class="col-md-5 mb-4 pb-2">

                                                                    <div class="form-outline form-white">
                                                                        <input type="text" id="cityform" name="city" class="form-control form-control-lg" required />
                                                                        <label class="form-label" for="cityform">City</label>
                                                                    </div>

                                                                </div>

                                                                <div class="col-md-5 mb-4 pb-2">

                                                                    <div class="form-outline form-white">
                                                                        <input type="text" id="zipform" name="zip" class="form-control form-control-lg" required />
                                                                        <label class="form-label" for="zipform">Zip Code</label>
                                                                    </div>

                                                                </div>

                                                                <div class="form-check d-flex justify-content-start mb-4 pb-3">
                                                                    <input class="form-check-input me-3" type="checkbox" value="" id="form2Example3c" required />
                                                                    <label class="form-check-label text-white" for="form2Example3">
                                                                        I do accept the <a href="#!" class="text-white"><u>Terms and Conditions</u></a> of your
                                                                        site.
                                                                    </label>
                                                                </div>

                                                                <button type="submit" class="btn custombutton btn-lg">Register and continue -></a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <?php require('templates/footer.php'); ?>
</body>