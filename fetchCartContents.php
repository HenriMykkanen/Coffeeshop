<?php
session_start();
require('lib/class.base.php');
require('lib/class.product.php');
require('lib/class.productimage.php');
require('lib/class.cart.php');
$cart = new cart($sql, 'carts');
$cart->session_id = session_id();
$cartContents = $cart->getCartContents();
$cartContents = json_encode($cartContents);
echo $cartContents;
?>