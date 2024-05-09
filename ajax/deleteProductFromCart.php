<?php
session_start();
require_once('../lib/class.base.php');
require_once('../lib/class.product.php');
require_once('../lib/class.productimage.php');
require_once('../lib/class.cart.php');

$errors = [];
$data = [];

if ($_POST['requestType'] == 'deleteFromCart') {
    $cartItem = new cart($_POST['id'], $sql, 'carts');
    if ($cartItem->delete()) {
        $data['success'] = true;
        $data['message'] = 'Success!';
    } else {
        $data['success'] = false;
        $data['message'] = 'Failure';
    }
}
echo json_encode($data);
