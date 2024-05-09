<?php
require_once('db.php');
class order extends base
{
    public $customer_id;
    public $createdate;
    public $finishdate;
    public $price;
    public $price_notax;
    public $status;
    public $deliveryMethod;
    public $paymentMethod;

    public function init()
    {
        $result = $this->sql->query("SELECT * FROM orders WHERE id = '" . $this->id . "'");

        $row = $result->fetch_assoc();
        $this->customer_id = $row['customer_id'];
        $this->createdate = $row['createdate'];
        $this->finishdate = $row['finishdate'];
        $this->price = $row['price'];
        $this->price_notax = $row['price_notax'];
        $this->status = $row['status'];
        $this->deliveryMethod = $row['deliverymethod'];
        $this->paymentMethod = $row['paymentmethod'];
    }

    public function addOrder(): bool
    {
        // Createdate is NOW, finishdate is empty, status is pending by default
        if ($this->sql->query("INSERT INTO orders (customer_id, createdate, finishdate, price, price_notax, status, deliverymethod, paymentmethod)
        VALUES
        ('" . $this->customer_id . "',
        '" . $this->createdate . "',
        '',
        '" . $this->price . "',
        '" . $this->price_notax . "',
        'pending',
        '" . $this->deliveryMethod . "',
        '" . $this->paymentMethod . "')")) {
            return true;
        } else {
            return false;
        }
    }
}
