<?php
require('lib/class.base.php');
require('lib/class.product.php');
require('lib/class.productimage.php');

$data = json_decode(file_get_contents('php://input'), true);
$category_id = $data['category_id'];

$product = new product($sql, 'products');
$products = $product->getProductsFromCategory($category_id);
$products = json_encode($products);
echo $products;
?>