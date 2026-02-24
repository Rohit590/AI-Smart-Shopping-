<?php
session_start();
include("includes/db.php");

$cart_id = $_POST['cart_id'];

mysqli_query($conn,"DELETE FROM cart WHERE id='$cart_id'");

header("Location: cart.php");
?>
