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

if(!isset($_POST["travelType"]))
{
    error("Rit type is niet geldig");
} elseif (strlen($_POST["travelType"]) > 255) {
    error("Rit type is niet geldig");
}

if(!isset($_POST["origin"]))
{
    error("Vertrekplaats is niet geldig");
} elseif (strlen($_POST["origin"]) > 255) {
    error("Vertrekplaats is niet geldig");
}

if(!isset($_POST["destination"]))
{
    error("Bestemming is niet geldig");
} elseif (strlen($_POST["destination"]) > 255) {
    error("Bestemming is niet geldig");
}

if(!isset($_POST["destinationName"]))
{
    error("Bestemming naam is niet geldig");
} elseif (strlen($_POST["destinationName"]) > 255) {
    error("Bestemming naam is niet geldig");
}

if(!isset($_POST["oldTotal"]))
{
    error("Beginstand kilometers is niet geldig!");
} if (is_numeric($_POST["oldTotal"]) == false) {
    error("Beginstand kilometers is niet geldig!");
}

if(!isset($_POST["newTotal"]))
{
    error("Eindstand kilometers is niet geldig!");
} if (is_numeric($_POST["newTotal"]) == false) {
    error("Eindstand kilometers is niet geldig!");
}

if(!isset($_POST["distance"]))
{
    error("Afstand is niet geldig!");
} if (is_numeric($_POST["distance"]) == false) {
    error("Afstand is niet geldig!");
}

if(!isset($_POST["travelDuration"]))
{
    error("Reistijd is niet geldig!");
} if (is_numeric($_POST["travelDuration"]) == false) {
    error("Reistijd is niet geldig!");
}

if(!isset($_POST["travelDate"]))
{
    error("Datum is niet geldig!");
}

$travelType = $_POST["travelType"];
$origin = $_POST["origin"];
$destination = $_POST["destination"];
$destinationName = $_POST["destinationName"];
$oldTotal = $_POST["oldTotal"];
$newTotal = $_POST["newTotal"];
$distance = $_POST["distance"];
$travelDuration = $_POST["travelDuration"];
$travelDate = $_POST["travelDate"];


$sql = "INSERT INTO travel_overview VALUES (DEFAULT, '$oldTotal', '$newTotal', '$origin', '$destination', '$destinationName', '$distance', '$travelDuration', '$travelType', '$travelDate')";

if ($conn->query($sql) === TRUE) {
    print json_encode([
        "success" => true,
        "message" => "Rit succesvol toegevoegd!",
        "address" => $destination,
        "addressName" => $destinationName,
    ]);
} else {
    error("something went wrong");
}

$conn->close();
exit();