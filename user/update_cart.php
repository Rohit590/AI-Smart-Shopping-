<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['cart_id']) && isset($_POST['action'])){

    $cart_id = $_POST['cart_id'];
    $action = $_POST['action'];

    if($action == "increase"){
        mysqli_query($conn,
            "UPDATE cart SET quantity = quantity + 1 WHERE id='$cart_id'"
        );
    }

    if($action == "decrease"){
        mysqli_query($conn,
            "UPDATE cart 
             SET quantity = IF(quantity > 1, quantity - 1, 1)
             WHERE id='$cart_id'"
        );
    }
}

header("Location: my_cart.php");
exit();
?>
