<?php
include_once 'db_connection.php';
include_once 'Product.php';


class manageData
{
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
        $typeProduct=$product->getType();
        echo "echo product";
        $insertProduct1 = mysqli_query($db_conn->con,
            "INSERT INTO `products` ( `sku`, `name`,`price`,`type`) 
            VALUES ('" . $product->getSku() . "','" . $product->getName() . "','" . $product->getPrice() . "','" . $product->getType() . "')");
        
        if ($typeProduct == "Book"){
            echo "echo book";
            return $this->insertBook();
        }
        else if($typeProduct == "DVD") {
            
            return $this->insertDVD();
        }
        else if ($typeProduct == "Furniture"){
            return $this->insertFurniture();
        }
    }
    public function insertBook()
    {
        $data = json_decode(file_get_contents("php://input"));
        $db_conn= new Database();

        $type = mysqli_real_escape_string($db_conn->con, trim($data->type));
        $weight = mysqli_real_escape_string($db_conn->con, trim($data->weight));

        $book = new Book (null,null,null,null,null);
        $book->setType($type);
        $book->setWeight($weight);

        $last_type = $book->getType();
        $query = mysqli_query($db_conn->con,"SELECT ID FROM products WHERE ID = ( SELECT MAX(ID) FROM products)");
        $result = mysqli_fetch_assoc($query);
        $last_id = $result['ID'];

        $query2 = mysqli_query($db_conn->con, "select COLUMN_NAME from information_schema.columns where
                                                       table_name='$last_type' and COLUMN_NAME like 'Weight'");
        $result1 = mysqli_fetch_assoc($query2);
        $column = $result1['COLUMN_NAME'];
        $weight = $book->getWeight();

        $insertProduct1 = mysqli_query($db_conn->con,
            "INSERT INTO   book  ( `id`,`type`,`$column`) 
            VALUES ('$last_id','$last_type','$weight')  ");
        if ($insertProduct1) {

            echo json_encode(["success" => 1, "msg" => "Product Added.", "id" => $last_id]);
            return true;
        } else {
            echo json_encode(["success" => 0, "msg" => "Product Not Added!"]);
            return false;

        }

    }
    public function insertDVD()
    {
        $db_conn = new Database();
        $data = json_decode(file_get_contents("php://input"));
        $size = mysqli_real_escape_string($db_conn->con, trim($data->size));
        $type = mysqli_real_escape_string($db_conn->con, trim($data->type));

        $dvd = new DVD(null,null,null,null,null);
        $dvd->setType($type);
        $dvd->setSize($size);

        $last_type = $dvd->getType();

        $query = mysqli_query($db_conn->con,"SELECT ID FROM products WHERE ID = ( SELECT MAX(ID) FROM products)");
        $result = mysqli_fetch_assoc($query);
        $last_id = $result['ID'];
        $query2 = mysqli_query($db_conn->con, "select COLUMN_NAME from information_schema.columns where
                                                       table_name='$last_type' and COLUMN_NAME like 'size'");
        $result1 = mysqli_fetch_assoc($query2);
        $column = $result1['COLUMN_NAME'];
        $size = $dvd->getSize();

        $insertProduct2 = mysqli_query($db_conn->con,
            "INSERT INTO   dvd  ( `id`,`type`,`$column`) 
            VALUES ('$last_id','$last_type','$size')  ");
        if ($insertProduct2) {

            echo json_encode(["success" => 1, "msg" => "Product Added.", "id" => $last_id]);
        } else {
            echo json_encode(["success" => 0, "msg" => "Product Not Added!"]);
        }

    }
    public function insertFurniture()
    {
        $data = json_decode(file_get_contents("php://input"));

        $db_conn = new Database();
        $type = mysqli_real_escape_string($db_conn->con, trim($data->type));
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

        $insertProduct3 = mysqli_query($db_conn->con,
            "INSERT INTO   furniture  ( `id`,`type`,`height`,`width`,`length`) 
            VALUES ('$last_id','$last_type','$height','$width','$length')  ");
        if ($insertProduct3) {

            echo json_encode(["success" => 1, "msg" => "Product Added.", "id" => $last_id]);
        } else {
            echo json_encode(["success" => 0, "msg" => "Product Not Added!"]);
        }


    }



    public function displayProduct()
    {
        $db_conn = new Database();

        $query = "SELECT products.ID,products.SKU,products.NAME,products.PRICE,products.Type,dvd.Size,book.Weight,furniture.height,furniture.width,furniture.length FROM products
LEFT OUTER JOIN dvd ON products.ID = dvd.id
LEFT OUTER JOIN book ON products.ID = book.id
LEFT OUTER JOIN furniture ON products.ID = furniture.id";

        $result = $db_conn->con->query($query);
        if ($result->num_rows > 0) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return json_encode(["success" => 1, "products" => $data]);;
        } else {
            echo "No found records";
        }
    }

    public function deleteProduct()
    {

        $data = json_decode(file_get_contents("php://input"));
        $db_conn = new Database();

        if ($data) {
            $deleteProduct1 = mysqli_query($db_conn->con, "DELETE FROM `dvd` WHERE dvd.id IN (" . implode(',', $data) . ")");
            $deleteProduct2 = mysqli_query($db_conn->con, "DELETE FROM `furniture` WHERE  furniture.id IN (" . implode(',', $data) . ")");
            $deleteProduct3 = mysqli_query($db_conn->con, "DELETE FROM `book` WHERE book.id IN (" . implode(',', $data) . ")");
            $deleteProduct4 = mysqli_query($db_conn->con, "DELETE FROM `products` WHERE products.ID IN (" . implode(',', $data) . ")");

            if ($deleteProduct1 || $deleteProduct2 || $deleteProduct3 || $deleteProduct4) {
                echo json_encode(["success" => 1, "msg" => "Product Deleted"]);
            } else {
                echo json_encode(["success" => 0, "msg" => "Product Not Found!"]);
            }
        } else {
            echo json_encode(["success" => 0, "msg" => "Product Not Found!"]);
        }
    }

}
