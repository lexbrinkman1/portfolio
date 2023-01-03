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

$sql = "SELECT * FROM travel_overview";

if ($conn->query($sql) === TRUE) {
    print json_encode([
        "success" => true,
        "message" => "Rit succesvol toegevoegd!",
        "address" => $destination,
    ]);
} else {
    error("something went wrong");
}

$conn->close();
exit();