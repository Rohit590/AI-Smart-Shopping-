<?php
session_start();
include("../includes/db.php");

if(!isset($_GET['order_id'])){
    header("Location: dashboard.php");
    exit();
}

$order_id = $_GET['order_id'];

/* GET ORDER DETAILS */

$order = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM orders WHERE id='$order_id'
"));

/* GET ORDER PRODUCTS */

$items = mysqli_query($conn,"
SELECT products.name, products.price, products.image, order_items.quantity
FROM order_items
JOIN products ON order_items.product_id = products.id
WHERE order_items.order_id='$order_id'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Invoice</title>

<style>

:root{
--cream:#fae4cf;
--navy:#0a0f23;
}

/* BODY */

body{
font-family:Arial;
background:var(--cream);
margin:0;
}

/* INVOICE BOX */

.invoice-container{
width:800px;
margin:40px auto;
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

/* HEADER */

.invoice-header{
display:flex;
justify-content:space-between;
align-items:center;
border-bottom:2px solid #eee;
padding-bottom:15px;
}

.logo{
height:45px;
}

.order-info{
text-align:right;
}

/* TABLE */

table{
width:100%;
border-collapse:collapse;
margin-top:25px;
}

th{
background:#0a0f23;
color:white;
padding:10px;
text-align:left;
}

td{
padding:10px;
border-bottom:1px solid #eee;
}

/* TOTAL */

.total-box{
text-align:right;
margin-top:20px;
font-size:18px;
font-weight:bold;
}

/* BUTTONS */

.btn-box{
margin-top:25px;
display:flex;
gap:15px;
}

.btn{
padding:10px 20px;
border:none;
border-radius:6px;
cursor:pointer;
font-weight:bold;
}

.print-btn{
background:#0a0f23;
color:white;
}

.home-btn{
background:#fae4cf;
}

</style>

</head>

<body>

<div class="invoice-container">

<!-- HEADER -->

<div class="invoice-header">

<div>
<img src="../assets/logo.png" class="logo">
<h3>AI Smart Shopping</h3>
</div>

<div class="order-info">
<p><b>Order ID:</b> #<?php echo $order_id; ?></p>
<p><b>Date:</b> <?php echo date("d M Y"); ?></p>
</div>

</div>

<!-- CUSTOMER DETAILS -->

<h3>Shipping Details</h3>

<p>
<b>Name:</b> <?php echo $order['name']; ?><br>
<b>Phone:</b> <?php echo $order['phone']; ?><br>
<b>Address:</b> <?php echo $order['address']; ?><br>
<b>Payment:</b> <?php echo strtoupper($order['payment_method']); ?>
</p>

<!-- PRODUCT TABLE -->

<table>

<tr>
<th>Product</th>
<th>Price</th>
<th>Quantity</th>
<th>Total</th>
</tr>

<?php

$grand_total = 0;

while($item = mysqli_fetch_assoc($items)){

$subtotal = $item['price'] * $item['quantity'];
$grand_total += $subtotal;

?>

<tr>

<td><?php echo $item['name']; ?></td>

<td>₹<?php echo $item['price']; ?></td>

<td><?php echo $item['quantity']; ?></td>

<td>₹<?php echo $subtotal; ?></td>

</tr>

<?php } ?>

</table>

<div class="total-box">
Grand Total: ₹<?php echo $grand_total; ?>
</div>

<div class="btn-box">

<button class="btn print-btn" onclick="window.print()">
Print Invoice
</button>

<a href="dashboard.php">
<button class="btn home-btn">
Back to Dashboard
</button>
</a>

</div>

</div>

</body>
</html>