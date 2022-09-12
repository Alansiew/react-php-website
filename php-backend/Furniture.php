<?php
include_once 'db_connection.php';
include_once 'Product.php';

class Furniture extends Product
{

    private $height;
    private $width;
    private $length;

    public function __construct($sku, $name, $price, $type, $height,$width,$length)
    {
        parent::__construct($sku, $name, $price, $type);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }
    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }
    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
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


        $height = mysqli_real_escape_string($db_conn->con, trim($data->height));
        $width = mysqli_real_escape_string($db_conn->con, trim($data->width));
        $length = mysqli_real_escape_string($db_conn->con, trim($data->length));
        $query = mysqli_query($db_conn->con,"SELECT ID FROM products WHERE ID = ( SELECT MAX(ID) FROM products)");
        $result = mysqli_fetch_assoc($query);
        $last_id = $result['ID'];

        $furniture = new Furniture(null,null,null,null,null,null,null);
        $furniture->setType($type);
        $furniture->setHeight($height);
        $furniture->setWidth($width);
        $furniture->setLength($length);
        $height = $furniture->getHeight();
        $width = $furniture->getWidth();
        $length = $furniture->getLength();
        $last_type = $furniture->getType();
        if ($add_product){
            
        $insertProduct3 = mysqli_query($db_conn->con,
            "INSERT INTO   furniture  ( `id`,`type`,`height`,`width`,`length`) 
            VALUES ('$last_id','$last_type','$height','$width','$length')  ");
        if ($insertProduct3) {

            echo json_encode(["success" => 1, "msg" => "Product Added.", "id" => $last_id]);
        } else {
            echo json_encode(["success" => 0, "msg" => "Product Not Added!"]);
        }

        }
    }

}
