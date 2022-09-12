<?php
include_once 'db_connection.php';
include_once 'Product.php';


class DVD extends Product
{
    private $size;

    public function __construct($sku, $name, $price, $type, $size)
    {
        parent::__construct($sku, $name, $price, $type);
        $this->size = $size;

    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }
    public function insertProduct()
    {
        $db_conn = new Database();
        $data = json_decode(file_get_contents("php://input"));
        $sku = mysqli_real_escape_string($db_conn->con, trim($data->sku));
        $name = mysqli_real_escape_string($db_conn->con, trim($data->name));
        $price = mysqli_real_escape_string($db_conn->con, trim($data->price));
        $type = mysqli_real_escape_string($db_conn->con, trim($data->type));

        $product = new $type(null,null,null,null,null,null,null);
        $product->setSku($sku);
        $product->setName($name);
        $product->setPrice($price);
        $product->setType($type);
        $sku=$product->getSku();
        $name = $product->getName();
        $price = $product->getPrice();
        $type = $product->getType();
        $add_product = mysqli_query($db_conn->con,
            "INSERT INTO `products` ( `sku`, `name`,`price`,`type`) 
            VALUES ('$sku','$name','$price','$type')");

        $size = mysqli_real_escape_string($db_conn->con, trim($data->size));


        $dvd = new DVD(null,null,null,null,null);
        $dvd->setType($type);
        $dvd->setSize($size);

        $type = $dvd->getType();
        $size = $dvd->getSize();
        
        $query = mysqli_query($db_conn->con,"SELECT ID FROM products WHERE ID = ( SELECT MAX(ID) FROM products)");
        $result = mysqli_fetch_assoc($query);
        $last_id = $result['ID'];


       
    if($add_product){
        $insertProduct2 = mysqli_query($db_conn->con,
            "INSERT INTO   dvd  ( `id`,`type`,`Size`) 
            VALUES ('$last_id','$type','$size')  ");
        if ($insertProduct2) {

            echo json_encode(["success" => 1, "msg" => "Product Added.", "id" => $last_id]);
        } else {
            echo json_encode(["success" => 0, "msg" => "Product Not Added!"]);
        }
        }
    }

}
