<?php
require('lib/class.base.php');
require('lib/class.product.php');
require('lib/class.productimage.php');

$json = file_get_contents('php://input');

$json = json_decode($json, true);

$productID = $json['id'];

$product = new product($productID, $sql, 'products');
$productAndImages = $product->getSingleProductAndImages();
$productAndImages = json_encode($productAndImages);
echo $productAndImages;
?>