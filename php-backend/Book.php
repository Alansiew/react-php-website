<?php
include_once 'db_connection.php';
include_once 'Product.php';

class Book extends Product
{
    private $weight;

    public function __construct($sku, $name, $price, $type, $weight)
    {
        parent::__construct($sku, $name, $price, $type);
        $this->weight = $weight;

    }
    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

}