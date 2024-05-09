<?php
require('lib/class.base.php');
require('lib/class.product.php');
require('lib/class.productimage.php');

$product = new product($sql, 'products');
$products = $product->getProductsAndImages();
$products = json_encode($products);
echo $products;
?>