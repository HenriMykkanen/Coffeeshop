<?php
session_start();
require('lib/class.base.php');
require('lib/class.product.php');
require('lib/class.productimage.php');
require('lib/class.cart.php');
require('lib/class.user.php');
require('lib/class.customer.php');
require('lib/class.admin.php');
require('lib/class.order.php');
require('lib/class.order_item.php');

$json = file_get_contents('php://input');

$json = json_decode($json, true);

$errors = [];
$data = [];

// Create a new order
$order = new order(null, $sql, 'orders');
$order->customer_id = $json['customerID'];
$order->createdate = date("Y-m-d H:i:s");
$order->price = $json['orderPriceTotal'];
$order->price_notax = $json['orderPriceNoTax'];
$order->deliveryMethod = $json['deliveryMethod'];
$order->paymentMethod = $json['paymentMethod'];

// Process the order
if ($order->addOrder()) {

    // Save the orderID of the order that was just created for later use
    $orderID = $sql->insert_id;

    // Add all the ordered items in the cart to the order_items table
    $cart = new cart(null, $sql, 'carts');
    $cart->session_id = session_id();
    $cartItems = $cart->getCartContents();

    foreach ($cartItems as $item) {
        $order_item = new order_item(null, $sql, 'order_items');
        $order_item->order_id = $orderID;
        $order_item->product_id = $item['product_id'];
        $order_item->name = $item['name'];
        $order_item->price = $item['price'];
        $order_item->tax = $item['tax'];
        $order_item->quantity = $item['quantity'];
        $order_item->createdate = $order->createdate;
        $order_item->addOrderItem();
    }

    // Send a confirmation email to the customer
    $customer = new customer($json['customerID'], $sql, 'users');
    $customer->init();
    if ($customer->sendConfirmationEmail($cartItems, $json['deliveryMethod'], $json['orderPriceTotal'])) {
        $data['success'] = true;
        $data['message'] = 'Success';
    }
    else {
        $data['success'] = false;
        $data['message'] = 'Failure';
    }
}
