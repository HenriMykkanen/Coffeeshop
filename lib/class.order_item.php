<?php
require_once('db.php');
class order_item extends base
{
    public $order_id;
    public $product_id;
    public $name;
    public $price;
    public $tax;
    public $quantity;
    public $createdate;

    public function init()
    {
        $result = $this->sql->query("SELECT * FROM order_items WHERE id = '" . $this->id . "'");

        $row = $result->fetch_assoc();
        $this->order_id = $row['order_id'];
        $this->product_id = $row['product_id'];
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->tax = $row['tax'];
        $this->quantity = $row['quantity'];
        $this->createdate = $row['status'];
    }

    public function addOrderItem(): bool
    {
        
        if ($this->sql->query("INSERT INTO order_items (order_id, product_id, name, price, tax, quantity, createdate)
        VALUES
        ('" . $this->order_id . "',
        '" . $this->product_id . "',
        '" . $this->name . "',
        '" . $this->price . "',
        '" . $this->tax . "',
        '" . $this->quantity . "',
        '" . $this->createdate . "')")) {
            return true;
        } else {
            return false;
        }
    }
}
