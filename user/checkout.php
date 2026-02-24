<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>

<style>

:root{
    --cream:#fae4cf;
    --navy:#0a0f23;
    --navy-light:#151b3a;
}

/* BODY */
body{
    font-family:Arial, sans-serif;
    background:var(--cream);
    margin:0;
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
    font-weight:600;
}

/* CHECKOUT CONTAINER */
.checkout-container{
    width:55%;
    margin:40px auto;
    background:var(--navy);
    padding:30px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
    color:var(--cream);
}

/* HEADINGS */
.checkout-container h2{
    margin-top:0;
}

.section-title{
    margin-top:25px;
    margin-bottom:10px;
    font-size:18px;
    border-bottom:1px solid rgba(255,255,255,0.2);
    padding-bottom:5px;
}

/* INPUTS */
input, textarea, select{
    width:100%;
    padding:11px;
    margin:10px 0;
    border-radius:6px;
    border:none;
    outline:none;
    background:#1c2340;
    color:white;
    font-size:14px;
}

input::placeholder,
textarea::placeholder{
    color:#cfcfcf;
}

/* BUTTON */
button{
    width:100%;
    padding:13px;
    background:var(--cream);
    color:var(--navy);
    border:none;
    border-radius:6px;
    font-weight:bold;
    cursor:pointer;
    margin-top:15px;
    transition:0.2s;
}

button:hover{
    background:#f2d5ba;
}

</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <h3>AI Smart Shopping</h3>
    <div>
        <a href="dashboard.php">< Dashboard</a>
        <a href="my_cart.php">Cart</a>
        <a href="logout.php">Logout</a>
    </div>
</div>


<div class="checkout-container">

    <h2>Checkout</h2>

    <form action="place_order.php" method="POST">

        <div class="section-title">Shipping Address</div>

        <input type="text" name="name"
               placeholder="Full Name" required>

        <input type="text" name="phone"
               placeholder="Phone Number" required>

        <textarea name="address"
                  placeholder="Full Address"
                  required></textarea>

        <div class="section-title">Payment Method</div>

        <select name="payment">
            <option value="cod">Cash on Delivery</option>
            <option value="upi">UPI</option>
            <option value="card">Credit/Debit Card</option>
        </select>

        <button type="submit">Place Order</button>

    </form>

</div>

</body>
</html>
