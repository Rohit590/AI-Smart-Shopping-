<?php
session_start();
include("includes/db.php");

// Stop Guest users
if(!isset($_SESSION['user_id'])){
    header("Location:user/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];

/* GET PRODUCT INFO FOR POPUP */
$p = mysqli_fetch_assoc(mysqli_query($conn,
      "SELECT name,image FROM products WHERE id='$product_id'"));

$product_name = $p['name'];
$product_image = $p['image'];

/* Check if already in cart */
$check = mysqli_query($conn,
    "SELECT * FROM cart 
     WHERE user_id='$user_id' 
     AND product_id='$product_id'"
);

if(mysqli_num_rows($check) > 0){

    mysqli_query($conn,
        "UPDATE cart 
         SET quantity = quantity + 1
         WHERE user_id='$user_id'
         AND product_id='$product_id'"
    );

}else{

    mysqli_query($conn,
        "INSERT INTO cart(user_id, product_id, quantity)
         VALUES('$user_id','$product_id',1)"
    );
}

header("Location: user/browse_products.php?added=1&name=".urlencode($product_name)."&img=".$product_image);
exit();
?>


