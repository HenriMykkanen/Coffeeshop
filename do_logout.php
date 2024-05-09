<?php
session_start();
require('lib/class.user.php');
require('lib/class.customer.php');
require('lib/class.admin.php');
$_SESSION['logged_in'] = false;
unset($_SESSION['user_role']);
unset($_SESSION['logged_id']);
header("Location: login.php");
?>