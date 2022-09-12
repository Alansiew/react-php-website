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
    public function insertProduct() {
        $db_conn = new Database();
        $data = json_decode(file_get_contents("php://input"));
       
        $sku = mysqli_real_escape_string($db_conn->con, trim($data->sku));
        $name = mysqli_real_escape_string($db_conn->con, trim($data->name));
        $price = mysqli_real_escape_string($db_conn->con, trim($data->price));
        $type = mysqli_real_escape_string($db_conn->con, trim($data->type));
        $weight = mysqli_real_escape_string($db_conn->con, trim($data->weight));

        

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

        $book = new Book (null,null,null,null,null);
        $book->setType($type);
        $book->setWeight($weight);
        
        $type = $book->getType();
        $weight = $book->getWeight();

        
        $query = mysqli_query($db_conn->con,"SELECT ID FROM products WHERE ID = ( SELECT MAX(ID) FROM products)");
        $result = mysqli_fetch_assoc($query);
        $last_id = $result['ID'];


    if ($add_product){
        $insertProduct1 = mysqli_query($db_conn->con,
            "INSERT INTO   book  ( `id`,`type`,`Weight`) 
            VALUES ('$last_id','$type','$weight')  ");
        if ($insertProduct1) {

            echo json_encode(["success" => 1, "msg" => "Product Added.", "id" => $last_id]);

            return true;
        } else {


            echo json_encode(["success" => 0, "msg" => "Product Not Added!"]);
            return false;

        }
        }
    }
}
