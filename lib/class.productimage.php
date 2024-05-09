<?php
require_once('db.php');
class productimage extends base
{
    public $productid;
    public $imagelink;
    public $description;

    public function init()
    {
        $result = $this->sql->query("SELECT * FROM productimages WHERE id = '" . $this->id . "'");

        $row = $result->fetch_assoc();
        $this->productid = $row['productid'];
        $this->imagelink = $row['imagelink'];
        $this->description = $row['description'];
    }

    public function addProductImage(): bool
    {

        if ($this->sql->query("INSERT INTO productimages (productid, imagelink, description)
    VALUES ('" . $this->productid . "', '" . $this->imagelink . "', '" . $this->description . "')")) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProductImage(): bool
    {
        if ($this->sql->query("UPDATE productimages SET productid = '".$this->productid."', imagelink = '".$this->imagelink."', description = '".$this->description."' WHERE id = '".$this->id."'")) {
            return true;
        } else {
            return false;
        }
    }

    public static function getProductImages() : array {

        global $sql;

        $images = [];

        $result = $sql->query("SELECT * FROM productimages ORDER BY name DESC");
        
        while ($row = $result->fetch_assoc()) {
            $images[] = $row;
        }

        return $images;
    }

}