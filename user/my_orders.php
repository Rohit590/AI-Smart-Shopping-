<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* GET USER ORDERS */
$orders = mysqli_query($conn,"
SELECT * FROM orders
WHERE user_id='$user_id'
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Orders</title>
<style>
body{
    font-family:Arial;
    background:#fae4cf;
}
.box{
    width:80%;
    margin:50px auto;
    background:white;
    padding:30px;
    border-radius:10px;
}

/* NAVBAR */
.navbar{
    background:var(--navy);
    color:var(--cream);
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.navbar a{
    color:var(--cream);
    text-decoration:none;
    margin-left:20px;
}

.order-card{
border:1px solid #ddd;
padding:20px;
margin-top:20px;
border-radius:8px;
background:#fafafa;
}

.order-table{
width:100%;
border-collapse:collapse;
margin-top:10px;
}

.order-table th,
.order-table td{
padding:10px;
border-bottom:1px solid #ddd;
text-align:left;
}

.invoice-btn{
margin-top:10px;
padding:8px 15px;
background:#0a0f23;
color:#fae4cf;
border:none;
border-radius:5px;
cursor:pointer;
}
</style>
</head>

<body>
    <div class="navbar">
        <h3>AI Smart Shopping</h3>
        <div>
            <a href="my_cart.php">Cart</a>
            <a href="dashboard.php">< Dashboard</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

<div class="box">
    <h2>My Orders</h2>
    <?php if(mysqli_num_rows($orders) == 0){ ?>

        <p>No orders yet.</p>

        <?php } else { ?>

        <?php while($order = mysqli_fetch_assoc($orders)){ ?>

        <div class="order-card">

        <h3>Order #<?php echo $order['id']; ?></h3>

        <p>
        <b>Date:</b> <?php echo date("d M Y", strtotime($order['created_at'])); ?><br>
        <b>Payment:</b> <?php echo strtoupper($order['payment_method']); ?><br>
        <b>Total:</b> ₹<?php echo $order['total_amount']; ?>
        </p>

        <table class="order-table">

        <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        </tr>

        <?php

        $items = mysqli_query($conn,"
        SELECT products.name, products.price, order_items.quantity
        FROM order_items
        JOIN products ON order_items.product_id = products.id
        WHERE order_items.order_id='".$order['id']."'
        ");

        while($item = mysqli_fetch_assoc($items)){
        ?>

        <tr>
        <td><?php echo $item['name']; ?></td>
        <td>₹<?php echo $item['price']; ?></td>
        <td><?php echo $item['quantity']; ?></td>
        </tr>

        <?php } ?>

        </table>

        <a href="invoice.php?order_id=<?php echo $order['id']; ?>">
        <button class="invoice-btn">View Invoice</button>
        </a>

        </div>

        <?php } ?>

        <?php } ?>
        </div>

</body>
</html>
