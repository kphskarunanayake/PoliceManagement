<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "dfmapsdb";

$con = mysqli_connect($host, $user, $password, $database);

if(!$con){
    die("Connection Error".mysqli_error($con));
}