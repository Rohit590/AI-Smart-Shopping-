<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ai_ecommerce";
$port = 3307;

$conn = mysqli_connect($servername, $username, $password, $database, $port);
if(!$conn){
    die("Connection failed due to this reason-->".mysqli_connect_error());
}
?>