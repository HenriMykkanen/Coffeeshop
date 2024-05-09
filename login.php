<?php
session_start();
$page = 'login';
$title = "LOGIN";
require('templates/header.php');
require('templates/navigation.php');
require('lib/class.user.php');
require('lib/class.customer.php');
require('lib/class.admin.php');
?>

<body">
    <section class="maincontent">
        <div class="container">
            <div class="card rounded">
                <div class="card-body">
                    <h3 class="text-center">Log in</h3>
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4 col-sm-12">
                            <form action="do_login.php" method="POST">
                                <div class="form-group">
                                    <label for="text">Email:</label>
                                    <input type="email" name="email" class="form-control" id="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="pwd">Password:</label>
                                    <input type="password" class="form-control" id="pwd" name="password" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="submit" class="btn custombutton-darktext mt-2"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                        </i>Login</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4"></div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <?php require('templates/footer.php'); ?>
</body>