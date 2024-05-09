<?php
session_start();
require_once('../lib/class.base.php');
require_once('../lib/class.product.php');
require_once('../lib/class.productimage.php');
require_once('../lib/class.cart.php');

$errors = [];
$data = [];

if ($_POST['requestType'] == 'addProductToCart') {
    $cartItem = new cart(null, $sql, 'carts');
    $cartItem->customer_id = $_SESSION['logged_id'];
    $cartItem->product_id = $_POST['id'];
    $cartItem->session_id = session_id();
    if (!$cartItem->isProductInCart()) {
        $cartItem->quantity = 1;
        $cartItem->addProductToCart();
        $data['success'] = true;
        $data['message'] = 'Success';
    } else if ($cartItem->isProductInCart()) {
        $oldQuantity = $cartItem->getProductQuantity();
        $newQuantity = $oldQuantity + 1;
        $cartItem->quantity = $newQuantity;
        $cartItem->updateProductQuantityInCart();
        $data['success'] = true;
        $data['message'] = 'Success';
    }
}
echo json_encode($data);
