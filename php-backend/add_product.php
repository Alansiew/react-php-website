<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'db_connection.php';
include_once 'Product.php';
include_once 'DVD.php';
include_once 'Book.php';
include_once 'Furniture.php';

$db_conn= new Database();
$data = json_decode(file_get_contents("php://input"));

$type = mysqli_real_escape_string($db_conn->con, trim($data->type));


$product = new $type(null,null,null,null,null,null,null);
$product->insertProduct();












