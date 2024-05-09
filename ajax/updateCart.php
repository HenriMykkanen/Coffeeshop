<?php
session_start();
require_once('../lib/class.base.php');
require_once('../lib/class.product.php');
require_once('../lib/class.productimage.php');
require_once('../lib/class.cart.php');

$errors = [];
$data = [];

if ($_POST['requestType'] == 'updateCart') {
    $cartItem = new cart(null, $sql, 'carts');
    $cartItem->product_id = $_POST['id'];
    $cartItem->quantity = $_POST['quantity'];
    $cartItem->session_id = session_id();
    if ($cartItem->updateProductQuantityInCart()) {
        $data['success'] = true;
        $data['message'] = 'Success!';
    } else {
        $data['success'] = false;
        $data['message'] = 'Failure';
    }
}
echo json_encode($data);
