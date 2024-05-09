<?php
require_once('db.php');
class customer extends user
{
    private $customerID;

    public function init()
    {

        $result = $this->sql->query("SELECT * FROM users WHERE id = '" . $this->id . "'");

        $row = $result->fetch_assoc();
        $this->firstname = $row['firstname'];
        $this->lastname = $row['lastname'];
        $this->street = $row['street'];
        $this->zip = $row['zip'];
        $this->city = $row['city'];
        $this->phone = $row['phone'];
        $this->email = $row['email'];
    }

    public function sendConfirmationEmail($arrayOfCartItems, $deliveryMethod, $totalPrice)
    {

        $firstname = $this->firstname;
        $lastname = $this->lastname;
        $street = $this->street;
        $zip = $this->zip;
        $city = $this->city;
        $phone = $this->phone;
        $email = $this->email;

        $cartItems = $arrayOfCartItems;
        $deliveryMethod = $deliveryMethod;
        $totalPrice = $totalPrice;
        $date = date("Y-m-d H:i:s");

        $subject = "Thank You for Your Recent Purchase at Coffee4U";
        $fromName = 'Coffee4U@demo.com';
        $from = 'Coffee Salesman';
        $message =
            "<!DOCTYPE html>
        <html>
          <head>
            <meta charset='UTF-8'>
            <title>Thank You for Your Recent Purchase at Coffee4U</title>
          </head>
          <body>
            <h1>Dear $firstname,</h1>
            <p>We at Coffee4U would like to express our heartfelt gratitude for choosing us for your coffee needs. We hope you are enjoying the product(s) you purchased, and we are delighted to have been able to provide you with a great shopping experience.</p>
            <p>At Coffee4U, we take pride in sourcing only the best quality coffee products and providing exceptional customer service. We strive to ensure that our customers receive their orders promptly and that they are always satisfied with their purchases.</p>
            <p>We value your patronage and hope that you will continue to choose Coffee4U for your coffee needs. If you have any questions or feedback, please do not hesitate to <a href='mailto:support@coffee4u.com'>contact us</a>. We would be more than happy to assist you.</p>
            <p>Here are the details of your order:</p>
            <p>First name: $firstname</p>
            <p>Last name: $lastname</p>
            <p>Street: $street</p>
            <p>Zip: $zip</p>
            <p>City: $city</p>
            <p>Phone: $phone</p>
            <p>Delivery method: $deliveryMethod</p>
            <p>Order placed at: $date</p>
            <p>Products: </p>
            <p>";
            foreach ($cartItems as $item) {
                $message .= $item['name']. ' - Quantity: ' . $item['quantity']. ' - Price: '. $item['price']. ' - Tax: '. $item['tax']. '<br>';
            }
            $message .=
            "</p>
            <p>Total price: $totalPrice</>
            <p>You will receive another email from us when your order has been shipped.</p>
            <p>Thank you again for your recent purchase, and we look forward to serving you again soon.</p>
            <br>
            <p>Warm regards,</p>
            <p>Coffee Salesman<br>Coffee4U Team</p>
          </body>
        </html>";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $headers .= 'From: ' . $fromName . '<' . $from . '>' . "\r\n";

        if (mail($email, $subject, $message, $headers)) {
            return true;
        } else {
            return false;
        }
    }

    public function getDeliveryInformation() : array
    {

        $deliveryInformation = [];

        global $sql;

        $result = $sql->query("SELECT firstname, lastname, street, zip, city, phone, email FROM users WHERE id = '" . $this->id . "'");

        if (!$result) {
            die("Query failed: " . $sql->error);
        }

        if ($result->num_rows == 0) {
            die("No delivery information found");
        }

        while ($row = $result->fetch_assoc()) {
            $deliveryInformation[] = $row;
        }

        return $deliveryInformation;
    }
}
