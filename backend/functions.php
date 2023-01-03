<?php 
require('UserInfo.php');
require_once('./config.php');

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
  
  if ($conn->connect_error) {
    error("Connection failed: " . $conn->connect_error);
  }

  $sql = "INSERT INTO user_activity (ip, device, os, browser, country, region_name, city, lat, lon, time_zone) VALUES ('$ip', '$device', '$os', '$browser', '$country', '$region_name', '$city', '$lat', '$lon', '$time_zone')";
      
  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}


?>

