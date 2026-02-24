<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}
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
    <p>No orders yet.</p>
</div>

</body>
</html>
