<?php
session_start();
require('lib/class.user.php');
require('lib/class.customer.php');

// Sanitize form input data
$firstname = $sql->real_escape_string($_POST['firstname']);
$lastname = $sql->real_escape_string($_POST['lastname']);
$street = $sql->real_escape_string($_POST['street']);
$zip = $sql->real_escape_string($_POST['zip']);
$city = $sql->real_escape_string($_POST['city']);
$phone = $sql->real_escape_string($_POST['phone']);
$email = $sql->real_escape_string($_POST['email']);
$password = $sql->real_escape_string($_POST['password']);

$customer = new customer(null, $sql, 'users', $email, $password);
$customer->firstname = $firstname;
$customer->lastname = $lastname;
$customer->street = $street;
$customer->zip = $zip;
$customer->city = $city;
$customer->phone = $phone;
$customer->role = 'customer';

$errors = [];

if (!$customer->isEmailUnique()) {
    $errors[] = "Email already exists";
}

if (count($errors) === 0) {
    $customer->addUser();
    $customerID = $sql->insert_id;
    $customer->login($email, $password);
    $_SESSION['user_role'] = 'customer';
    $_SESSION['logged_id'] = $customerID;
    $_SESSION['logged_in'] = true;
    $data = array(
        'customerID' => $customerID,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'phone' => $phone,
        'street' => $street,
        'city' => $city,
        'zip' => $zip
    );

    $json = json_encode($data);

    $_SESSION['deliveryinformation'] = $json;

    header("Location: deliverymethod.php");
} else {
    $_SESSION['errors'] = $errors;
    header("Location: deliveryinformation.php");
}
