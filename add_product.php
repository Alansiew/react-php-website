<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'db_connection.php';
// POST DATA
$data = json_decode(file_get_contents("php://input"));

if (
    isset($data->sku)
    && isset($data->name)
    && isset($data->price)
    && isset($data->type)

    && !empty(trim($data->sku))
    && !empty(trim($data->name))
    && !empty(trim($data->price))
    && !empty(trim($data->type))

)

{
    $sku = mysqli_real_escape_string($db_conn, trim($data->sku));
    $name = mysqli_real_escape_string($db_conn, trim($data->name));
    $price = mysqli_real_escape_string($db_conn, trim($data->price));
    $type = mysqli_real_escape_string($db_conn, trim($data->type));

    $insertProduct = mysqli_query($db_conn, "INSERT INTO `products` ( `sku`, `name`,`price`,`type`) VALUES (' $sku','$name','$price','$type')");
    $last_id = mysqli_insert_id($db_conn);

    if ($type == 'DVD') {
        $size = mysqli_real_escape_string($db_conn, trim($data->size)) ;
        $insertProduct2 = mysqli_query($db_conn, "INSERT INTO `dvd` (`id`,`size`,`type`) VALUES ('$last_id',' $size','$type')");
echo print_r($insertProduct2);
        echo json_encode($size);
        $row = mysqli_fetch_array($insertProduct2);
echo $row;
        if ($insertProduct2) {

            echo json_encode(["success" => 1, "msg" => "Product Added.", "id" => $last_id]);
        } else {
            echo json_encode(["success" => 0, "msg" => "Product Not Added!"]);
        }

    }
    elseif ($type == 'Book') {
        $weight = mysqli_real_escape_string($db_conn, trim($data->weight)) ;
        $insertProduct3 = mysqli_query($db_conn, " INSERT INTO `book` (`id`,`weight`,`type`) VALUES ('$last_id',' $weight','$type')");
        echo $last_id;
        if ($insertProduct3) {

            echo json_encode(["success" => 1, "msg" => "Product Added.", "id" => $last_id]);
        } else {
            echo json_encode(["success" => 0, "msg" => "Product Not Added!"]);
        }
    }
    elseif ($type == 'Furniture') {
        $height = mysqli_real_escape_string($db_conn, trim($data->height)) ;
        $width = mysqli_real_escape_string($db_conn, trim($data->width)) ;
        $length = mysqli_real_escape_string($db_conn, trim($data->length));
        $insertProduct4 = mysqli_query($db_conn, "INSERT INTO `furniture` ( `id`, `height`,`width`,`length`,`type`) VALUES ('$last_id',' $height',' $width',' $length','$type')");

    if ($insertProduct4) {

        echo json_encode(["success" => 1, "msg" => "Product Added.", "id" => $last_id]);
    } else {
        echo json_encode(["success" => 0, "msg" => "Product Not Added!"]);
    }
} else {
    echo json_encode(["success" => 0, "msg" => "Invalid!"]);
}
} else {
    echo json_encode(["success" => 0, "msg" => "Please fill all the required fields!"]);
}