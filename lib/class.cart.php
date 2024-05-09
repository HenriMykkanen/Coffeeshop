<?php
require_once('db.php');
class cart extends base
{
    public $customer_id;
    public $product_id;
    public $addDate;
    public $session_id;
    public $quantity;

    public function init()
    {
        $result = $this->sql->query("SELECT * FROM carts WHERE id = '" . $this->id . "'");

        $row = $result->fetch_assoc();
        $this->customer_id = $row['customer_id'];
        $this->product_id = $row['product_id'];
        $this->addDate = $row['adddate'];
        $this->session_id = $row['session_id'];
        $this->quantity = $row['quantity'];
    }

    public function addProductToCart(): bool
    {

        if ($this->sql->query("INSERT INTO carts (customer_id, product_id, adddate, session_id, quantity)
    VALUES ('" . $this->customer_id . "', '" . $this->product_id . "', NOW(), '" . $this->session_id . "', '" . $this->quantity . "')")) {
            return true;
        } else {
            return false;
        }
    }

    public function isProductInCart(): bool
    {
        global $sql;

        $result = $sql->query("SELECT product_id FROM carts WHERE session_id = '" . $this->session_id . "'");

        while ($row = $result->fetch_assoc()) {
            if ($row['product_id'] == $this->product_id) {
                return true;
            }
        }
        return false;

    }

    public function getProductQuantity(): int
    {
        global $sql;

        $result = $sql->query("SELECT quantity FROM carts WHERE product_id = '" . $this->product_id . "' AND session_id = '" . $this->session_id . "'");

        $row = $result->fetch_assoc();
        $productQuantity = (int)$row['quantity'];

        return $productQuantity;
    }

    public function updateProductQuantityInCart(): bool
    {

        if ($this->sql->query("UPDATE carts SET quantity = '" . $this->quantity . "' WHERE product_id = '" . $this->product_id . "' AND session_id = '".$this->session_id."'")) {
            return true;
        } else {
            return false;
        }
    }

    public function getCartItemCount(): int
    {

        global $sql;

        $cartItemCount = 0;

        $result = $sql->query("SELECT * FROM carts WHERE session_id = '" . $this->session_id . "'");

        if (!$result) {
            die("Query failed: " . $sql->error);
        }

        while ($result->fetch_assoc()) {
            $cartItemCount++;
        }

        return $cartItemCount;
    }

    public function getCartContents(): array
    {
        global $sql;

        $cartContents = [];

        $result = $sql->query("SELECT 
        products.id,
        products.name,
        products.price,
        products.tax,
        productimages.imagelink,
        carts.id AS cart_id,
        carts.quantity
        FROM 
        products
        INNER JOIN carts ON products.id = carts.product_id 
        INNER JOIN productimages ON carts.product_id = productimages.productid
        WHERE carts.session_id = '" . $this->session_id . "'");

        if (!$result) {
            die("Query failed: " . $sql->error);
        }

        while ($row = $result->fetch_assoc()) {
            $product_id = $row['id'];
            $cart_id = $row['cart_id'];
            if (!isset($cartContents[$product_id])) {
                // create a new entry for the product
                $cartContents[$product_id] = [
                    'product_id' => $product_id,
                    'cart_id' => $cart_id,
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'tax' => $row['tax'],
                    'imagelinks' => [],
                    'quantity' => $row['quantity'],
                ];
            }
            // add the imagelink to the array for the current product
            $cartContents[$product_id]['imagelinks'][] = $row['imagelink'];
        }

        return array_values($cartContents);
    }
}
