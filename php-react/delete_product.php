<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'db_connection.php';

$data = json_decode(file_get_contents("php://input"));

if ($data) {
    $deleteProduct1 = mysqli_query($db_conn, "DELETE FROM `dvd` WHERE dvd.id IN (" . implode(',', $data) . ")");
    $deleteProduct2 = mysqli_query($db_conn, "DELETE FROM `furniture` WHERE  furniture.id IN (" . implode(',', $data) . ")");
    $deleteProduct3 = mysqli_query($db_conn, "DELETE FROM `book` WHERE book.id IN (" . implode(',', $data) . ")");
    $deleteProduct4 = mysqli_query($db_conn, "DELETE FROM `products` WHERE products.ID IN (" . implode(',', $data) . ")");

    if ($deleteProduct1 ||$deleteProduct2||$deleteProduct3||$deleteProduct4) {
        echo json_encode(["success" => 1, "msg" => "Product Deleted"]);
    } else {
        echo json_encode(["success" => 0, "msg" => "Product Not Found!"]);
    }
} else {
    echo json_encode(["success" => 0, "msg" => "Product Not Found!"]);
}


