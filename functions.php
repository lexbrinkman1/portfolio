<?php 
require('UserInfo.php');

function userActivity() {
  $ip = UserInfo::get_ip();

  $data = file_get_contents('http://ip-api.com/json/'.$ip);
  
  list($status, $country, $country_code, $region, $region_name, $city, $zip, $lat, $lon, $time_zone, $isp, $org, $as, $query) = explode(",", $data);
  
  $device = UserInfo::get_device();
  $os = UserInfo::get_os();
  $browser = UserInfo::get_browser();
  $country = str_replace(array('"country":', '"'), "",$country);
  $region_name = str_replace(array('"regionName":', '"'), "",$region_name);
  $city = str_replace(array('"city":', '"'), "",$city);
  $lat = str_replace(array('"lat":', '"'), "",$lat);
  $lon = str_replace(array('"lon":', '"'), "",$lon);
  $time_zone = str_replace(array('"timezone":', '"'), "",$time_zone);
  
  $servername = "141.148.247.212";
  $username = "lex_brinkman_nl";
  $password = "sSS48h6e8xdFRjcm";
  $dbname = "lex_brinkman_nl";
  
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  $sql = "INSERT INTO user_activity (ip, device, os, browser, country, region_name, city, lat, lon, time_zone) VALUES ('$ip', '$device', '$os', '$browser', '$country', '$region_name', '$city', '$lat', '$lon', '$time_zone')";
      
  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}


?>

