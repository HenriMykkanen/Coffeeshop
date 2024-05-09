<?php
session_start();
require('lib/class.user.php');
require('lib/class.customer.php');
require('lib/class.admin.php');

$email = $_POST['email'];
$password = $_POST['password'];

$user = new user(null, $sql, 'users', $email, $password);

if ($result = $user->login($email, $password))
{
    $_SESSION['user_role'] = $result["role"];
    $_SESSION['logged_id'] = $result["id"];
    $_SESSION['logged_in'] = true;
    header("Location: index.php");
}
else {
    $errors[] = "Wrong login info";
    $_SESSION['errors'] = $errors;
    header("Location: login.php");
}
?>