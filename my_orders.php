<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* GET CART PRODUCTS */
$query = "
SELECT cart.*, products.name, products.price, products.image
FROM cart
JOIN products ON cart.product_id = products.id
WHERE cart.user_id='$user_id'
";

$result = mysqli_query($conn,$query);

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Cart</title>

<style>
body{
    margin:0;
    font-family: Arial, sans-serif;
    background:#fae4cf;
}

/* NAVBAR */
.navbar{
    background:#0a0f23;
    color:white;
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
}

.navbar a{
    color:#fae4cf;
    text-decoration:none;
    margin-left:20px;
}

/* MAIN LAYOUT */
.cart-wrapper{
    width:90%;
    margin:30px auto;
    display:flex;
    gap:30px;
    align-items:flex-start;
}

/* LEFT SIDE */
.cart-items{
    flex:2;
}

.cart-card{
    display:flex;
    justify-content:space-between;
    gap:20px;
    background:white;
    padding:15px;
    margin-bottom:20px;
    border-radius:10px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    align-items:center;
}

.cart-card img{
    width:110px;
    height:110px;
    object-fit:cover;
    border-radius:8px;
}

.cart-info h3{
    margin:0;
    color:#0a0f23;
}

.subtotal{
    font-weight:bold;
}

/* REMOVE BUTTON */
.remove-btn{
    background:#e74c3c;
    color:white;
    border:none;
    padding:8px 12px;
    border-radius:5px;
    cursor:pointer;
}

/* RIGHT SIDE SUMMARY */
.summary-box{
    flex:1;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    position:sticky;
    top:20px;
}

.summary-box h3{
    margin-top:0;
    color:#0a0f23;
}

.summary-row{
    display:flex;
    justify-content:space-between;
    margin:15px 0;
    font-size:18px;
}

.checkout-btn{
    width:100%;
    padding:12px;
    background:#0a0f23;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-weight:600;
}

.checkout-btn:hover{
    background:#151b3a;
}

.success-msg{
    width:90%;
    margin:15px auto;
    background:#0a0f23;
    color:#fae4cf;
    padding:12px;
    border-radius:6px;
    text-align:center;
}

.empty-cart{
    background:white;
    padding:20px;
    border-radius:10px;
    text-align:center;
}

.browse-btn{
    display:inline-block;
    margin-top:15px;
    padding:10px 18px;
    background:#0a0f23;
    color:#fae4cf;
    text-decoration:none;
    border-radius:6px;
    font-weight:600;
    transition:0.25s;
}

.browse-btn:hover{
    background:#151b3a;
}

</style>
</head>

<body>

    <div class="navbar">
        <h3>AI Smart Shopping</h3>
        <div>
            <a href="dashboard.php">< Dashboard</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <?php if(isset($_GET['removed'])){ ?>
    <div class="success-msg">
        Product removed from cart successfully
    </div>
    <?php } ?>

    <div class="cart-wrapper">

    <!-- LEFT SIDE -->
    <div class="cart-items">

    <h2>Your Cart</h2>

    <?php if(mysqli_num_rows($result) == 0){ ?>

        <div class="empty-cart">
            <p>Your cart is empty.</p>
           <a href="browse_products.php" class="browse-btn">
                Browse Products
            </a>
        </div>

    <?php } else { ?>

    <?php while($row = mysqli_fetch_assoc($result)){ 
        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;
    ?>

    <div class="cart-card">

        <img src="../assets/images/<?php echo $row['image']; ?>">

        <div class="cart-info">
            <h3><?php echo $row['name']; ?></h3>
            <p>Price: ₹<?php echo $row['price']; ?></p>
            <div style="display:flex; align-items:center; gap:8px;">

                <form method="POST" action="update_cart.php">
                    <input type="hidden" name="cart_id"
                        value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="action" value="decrease">
                    <button style="padding:4px 10px;">−</button>
                </form>

                <b><?php echo $row['quantity']; ?></b>

                <form method="POST" action="update_cart.php">
                    <input type="hidden" name="cart_id"
                        value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="action" value="increase">
                    <button style="padding:4px 10px;">+</button>
                </form>

                </div>

            <p class="subtotal">Subtotal: ₹<?php echo $subtotal; ?></p>
        </div>

        <form method="POST" action="remove_cart.php">
            <input type="hidden" name="cart_id"
                value="<?php echo $row['id']; ?>">
            <button class="remove-btn">Remove</button>
        </form>

    </div>

    <?php } ?>

    <?php } ?>

    </div>


    <!-- RIGHT SIDE SUMMARY -->
    <?php if($total > 0){ ?>
    <div class="summary-box">

        <h3>Order Summary</h3>

        <div class="summary-row">
            <span>Total Amount</span>
            <span>₹<?php echo $total; ?></span>
        </div>

        <a href="checkout.php">
            <button class="checkout-btn">
                Proceed to Checkout
            </button>
        </a>


    </div>
    <?php } ?>

    </div>

</body>
</html>
