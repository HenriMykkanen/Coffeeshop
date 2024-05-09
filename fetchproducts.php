<?php
require('lib/class.base.php');
require('lib/class.product.php');

$product = new product($sql, 'products');
$products = $product->getProducts();
$products = json_encode($products);
echo $products;
?>