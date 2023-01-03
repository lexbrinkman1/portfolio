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
    error($_POST["address"]);
} elseif (strlen($_POST["address"]) > 255) {
    error($_POST["address"]);
}

$address = $_POST["address"];

$sql = "SELECT * FROM address WHERE address = '$address'";

$result = $conn->query($sql);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        print json_encode([
            "success" => true,
            "exists" => true,
            "message" => "Address already exists",
        ]);
    } else {
        print json_encode([
            "success" => true,
            "exists" => false,
            "address" => $address,
        ]);
    }
   
} else {
    error("something went wrong");
}

$conn->close();
exit();