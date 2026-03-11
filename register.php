<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$payment = $_POST['payment'];

/* GET CART ITEMS */

$cart = mysqli_query($conn,"
SELECT cart.*, products.price
FROM cart
JOIN products ON cart.product_id = products.id
WHERE cart.user_id='$user_id'
");

$total = 0;

while($row = mysqli_fetch_assoc($cart)){
    $total += $row['price'] * $row['quantity'];
}

/* SAVE ORDER */

mysqli_query($conn,"
INSERT INTO orders(user_id,name,phone,address,total_amount,payment_method)
VALUES('$user_id','$name','$phone','$address','$total','$payment')
");

$order_id = mysqli_insert_id($conn);

/* SAVE ORDER ITEMS */

$cart = mysqli_query($conn,"
SELECT * FROM cart WHERE user_id='$user_id'
");

while($row = mysqli_fetch_assoc($cart)){

    mysqli_query($conn,"
    INSERT INTO order_items(order_id,product_id,quantity)
    VALUES('$order_id','".$row['product_id']."','".$row['quantity']."')
    ");
}

/* CLEAR CART */

mysqli_query($conn,"
DELETE FROM cart WHERE user_id='$user_id'
");

/* REDIRECT TO INVOICE */

header("Location: order_success.php?order_id=".$order_id);
exit();
?>