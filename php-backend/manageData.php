<?php
include_once 'db_connection.php';
include_once 'Product.php';


class manageData
{
  

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
