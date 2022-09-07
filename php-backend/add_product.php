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
include_once 'manageData.php';
$db_conn= new Database();


$product = new manageData;


$product=$manageData->insertProduct();











