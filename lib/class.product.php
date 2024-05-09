<?php
require_once('db.php');
class product extends base
{
    public $name;
    public $description;
    public $price;
    public $tax;
    public $category_id;

    public function init()
    {
        $result = $this->sql->query("SELECT * FROM products WHERE id = '" . $this->id . "'");

        $row = $result->fetch_assoc();
        $this->name = $row['name'];
        $this->description = $row['description'];
        $this->price = $row['price'];
        $this->tax = $row['tax'];
        $this->category_id = $row['category_id'];
    }

    public function addProduct(): bool
    {

        if ($this->sql->query("INSERT INTO products (name, description, price, tax, category_id)
    VALUES ('" . $this->name . "', '" . $this->description . "', '" . $this->price . "', '" . $this->tax . "', '" . $this->category_id . "')")) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProduct(): bool
    {
        if ($this->sql->query("UPDATE products SET name = '" . $this->name . "', description = '" . $this->description . "', price = '" . $this->price . "', tax = '" . $this->tax . "' WHERE id = '" . $this->id . "'")) {
            return true;
        } else {
            return false;
        }
    }

    public static function getProducts(): array
    {

        global $sql;

        $products = [];

        $result = $sql->query("SELECT * FROM products ORDER BY name DESC");

        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }

    public static function getProductsAndImages(): array
    {

        global $sql;

        $products = [];

        $result = $sql->query("SELECT products.id, products.name, products.description, products.price, products.tax, productimages.imagelink, productimages.id AS image_id, products.category_id FROM products INNER JOIN productimages ON products.id = productimages.productid");

        while ($row = $result->fetch_assoc()) {
            $product_id = $row['id'];
            if (!isset($products[$product_id])) {
                // create a new entry for the product
                $products[$product_id] = $row;
                // initialize an empty array for the imagelinks
                $products[$product_id]['imagelinks'] = [];
            }
            // add the imagelink and id to the array for the current product
            $products[$product_id]['imagelinks'][] = array(
                'imagelink' => $row['imagelink'],
                'image_id' => $row['image_id']
            );
        }

        return array_values($products);
    }

    public static function getProductsFromCategory($category_id): array
    {

        global $sql;

        $products = [];

        $result = $sql->query("SELECT products.id, products.name, products.price, products.tax, productimages.imagelink, productimages.id AS image_id, products.category_id FROM products INNER JOIN productimages ON products.id = productimages.productid WHERE products.category_id = $category_id");

        while ($row = $result->fetch_assoc()) {
            $product_id = $row['id'];
            if (!isset($products[$product_id])) {
                // create a new entry for the product
                $products[$product_id] = $row;
                // initialize an empty array for the imagelinks
                $products[$product_id]['imagelinks'] = [];
            }
            // add the imagelink and id to the array for the current product
            $products[$product_id]['imagelinks'][] = array(
                'imagelink' => $row['imagelink'],
                'image_id' => $row['image_id']
            );
        }

        return array_values($products);
    }

    public function getSingleProductAndImages(): array
    {

        
        global $sql;

        $productAndImages = [];

        $result = $sql->query("SELECT products.id, products.name, products.description, products.price, productimages.imagelink, products.category_id FROM products, productimages WHERE products.id = '". $this->id ."' AND productimages.productid = '". $this->id ."'");

        if (!$result) {
            die("Query failed: " . $sql->error);
        }

        while ($row = $result->fetch_assoc()) {
            $productAndImages[] = $row;
        }

        return $productAndImages;
    }
}
