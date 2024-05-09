<?php

require_once('../lib/class.base.php');
require_once('../lib/class.product.php');
require_once('../lib/class.productimage.php');

$errors = [];
$data = [];

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    // Add new product
    if ($_POST['formtype'] == 'addproduct') {

        // New product object
        $product = new product(null, $sql);
        $product->name = $sql->real_escape_string($_POST['name']);
        $product->description = $sql->real_escape_string($_POST['description']);
        $product->price = $sql->real_escape_string($_POST['price']);
        $product->tax = $sql->real_escape_string($_POST['tax']);
        $product->category_id = $sql->real_escape_string($_POST['category']);
        if ($product->addProduct()) {
            $data['success'] = true;
            $data['message'] = 'Success!';
        } else {
            $data['success'] = false;
            $data['message'] = 'Failure';
        }

        $productid = $sql->insert_id;
        $product_images = $_POST['imagelink'];

        // New productimage object using the ID of the product created above
        foreach ($product_images as $image)
        {
            $productimage = new productimage(null, $sql);
            $productimage->productid = $productid;
            $productimage->imagelink = $image;
            $productimage->description = $_POST['name'];
            if ($productimage->addProductImage()) {
                $data['success'] = true;
                $data['message'] = 'Success!';
            } else {
                $data['success'] = false;
                $data['message'] = 'Failure';
            }
        }
    }
    // Edit existing product
    if ($_POST['formtype'] == 'editproduct') {
        $product = new product($_POST['id'], $sql, 'products');

        $product->name = $sql->real_escape_string($_POST['name']);
        $product->description = $sql->real_escape_string(($_POST['description']));
        $product->price = $sql->real_escape_string($_POST['price']);
        $product->tax = $sql->real_escape_string($tax = $_POST['tax']);
        $product->category_id = $sql->real_escape_string($tax = $_POST['category']);
        if ($product->updateProduct()) {
            $data['success'] = true;
            $data['message'] = 'Success!';
        } else {
            $data['success'] = false;
            $data['message'] = 'Failure';
        }
        

        $product_images = $_POST['imagelink'];
        $productimage_ids = $_POST['imageID'];

        for ($i=0; $i < count($product_images) ; $i++) { 

            $productimage = new productimage($productimage_ids[$i], $sql, 'productimages');
            $productimage->productid = $_POST['id'];
            $productimage->imagelink = $product_images[$i];
            $productimage->description = $_POST['name'];
            if ($productimage->updateProductImage()) {
                $data['success'] = true;
                $data['message'] = 'Success!';
            } else {
                $data['success'] = false;
                $data['message'] = 'Failure';
            }
        }
    }
    // Delete existing product
    if ($_POST['formtype'] == 'deleteproduct') {
        $product = new product($_POST['id'], $sql, 'products');
        if ($product->delete()) {
            $data['success'] = true;
            $data['message'] = 'Success!';
        } else {
            $data['success'] = false;
            $data['message'] = 'Failure';
        }
    }
}
echo json_encode($data);
