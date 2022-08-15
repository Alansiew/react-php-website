<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods", "GET, POST, DELETE, PUT");
require 'db_connection.php';
$allProducts = mysqli_query($db_conn, "SELECT products.ID,products.SKU,products.NAME,products.PRICE,products.Type,dvd.Size,book.Weight,furniture.height,furniture.width,furniture.length FROM products
LEFT OUTER JOIN dvd ON products.ID = dvd.id
LEFT OUTER JOIN book ON products.ID = book.id
LEFT OUTER JOIN furniture ON products.ID = furniture.id

;");
if (mysqli_num_rows($allProducts) > 0) {
    $all_products = mysqli_fetch_all($allProducts, MYSQLI_ASSOC);
    echo json_encode(["success" => 1, "products" => $all_products]);
} else {
    echo json_encode(["success" => 0]);
}