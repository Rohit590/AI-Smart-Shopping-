<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['cart_id'])){

    $cart_id = $_POST['cart_id'];
    $user_id = $_SESSION['user_id'];

    mysqli_query($conn,
        "DELETE FROM cart 
         WHERE id='$cart_id' 
         AND user_id='$user_id'"
    );
}

header("Location: my_cart.php?removed=1");
exit();
?>
