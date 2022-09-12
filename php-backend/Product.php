<?php
include_once 'db_connection.php';
include_once 'manageData.php';

 abstract class Product
{
    private $sku;
    private $name;
    private $price;
    private $type;

     public function __construct($sku, $name, $price, $type)
     {
         $this->sku = $sku;
         $this->name = $name;
         $this->price = $price;
         $this->type = $type;

     }
     public function getSku() {
         return $this->sku;
     }
     public function setSku($sku)
     {
         $this->sku = $sku;
     }
    public function getName() {
        return $this->name;
    }
     public function setName($name)
     {
         $this->name = $name;
     }
    public function getPrice() {
        return $this->price;
    }
     public function setPrice($price)
     {
         $this->price = $price;
     }
    public function getType() {
        return $this->type;
    }
     public function setType($type)
     {
         $this->type = $type;
     }
     abstract public function insertProduct();


}
