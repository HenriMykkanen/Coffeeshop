<?php
session_start();
require('lib/class.base.php');
require('lib/class.product.php');
require('lib/class.productimage.php');
require('lib/class.cart.php');
$cart = new cart(null, $sql, 'carts');
$cart->session_id = session_id();
$cartItemCount =  $cart->getCartItemCount();
json_encode($cartItemCount);
echo $cartItemCount;
?>