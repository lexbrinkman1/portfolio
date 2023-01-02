<?php
session_start();
header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');

header("Access-Control-Allow-Methods: GET");

header("Allow: POST");

header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

require_once "../config.php";

function error($text) {
    print json_encode([
        "success" => false,
        "error" => $text,
    ]);
    exit();
}

if ($conn->connect_error) {
    error("Connection failed: " . $conn->connect_error);
}

if(!isset($_POST["address"]))
{
    error("Adres is niet geldig");
} elseif (strlen($_POST["address"]) > 255) {
    error("Adres is niet geldig");
}

if(!isset($_POST["addressName"]))
{
    error("Adres naam is niet geldig");
} elseif (strlen($_POST["addressName"]) > 255) {
    error("Adres naam is niet geldig");
}


$address = $_POST["address"];
$addressName = $_POST["addressName"];

$sql = "INSERT INTO address VALUES (DEFAULT, '$addressName', '$address')";

if ($conn->query($sql) === TRUE) {
    print json_encode([
        "success" => true,
    ]);
} else {
    error("something went wrong");
}

$conn->close();
exit();