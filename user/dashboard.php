<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>

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
        align-items:center;
    }

    .navbar a{
        color:#fae4cf;
        text-decoration:none;
        margin-left:20px;
        font-weight:600;
    }

    .navbar a.active{
        border-bottom:2px solid #fae4cf;
        padding-bottom:3px;
    }

    /* CONTAINER */
    .container{
        width:90%;
        margin:30px auto;
    }

    /* WELCOME */
    .welcome{
        background:#0a0f23;
        color:white;
        padding:25px;
        border-radius:10px;
        margin-bottom:25px;
    }

    /* DASHBOARD CARDS */
    .card-container{
        display:flex;
        gap:20px;
        flex-wrap:wrap;
    }

    .card{
        flex:1;
        min-width:200px;
        background:#0a0f23;
        color:white;
        padding:20px;
        border-radius:10px;
        text-align:center;
    }

    .card a{
        display:inline-block;
        margin-top:10px;
        padding:8px 14px;
        background:#fae4cf;
        color:#0a0f23;
        text-decoration:none;
        border-radius:5px;
        font-weight:600;
    }

    </style>
</head>

<body>

<div class="navbar">
    <h3>AI Smart Shopping</h3>

    <div>

        <a class="<?php echo ($current_page=='dashboard.php')?'active':''; ?>"
           href="dashboard.php">Dashboard</a>

        <a class="<?php echo ($current_page=='browse_products.php')?'active':''; ?>"
           href="browse_products.php">Browse</a>

        <a class="<?php echo ($current_page=='my_cart.php')?'active':''; ?>"
           href="my_cart.php">Cart</a>

        <a href="logout.php">Logout</a>

    </div>
</div>


<div class="container">

    <div class="welcome">
        <h2>Welcome, <?php echo $_SESSION['user_name']; ?> 👋</h2>
        <p>Explore products and continue your shopping.</p>
    </div>

    <div class="card-container">

        <div class="card">
            <h3>Browse Products</h3>
            <p>Discover new items recommended for you.</p>
            <a href="browse_products.php">View Products</a>
        </div>

        <div class="card">
            <h3>My Cart</h3>
            <p>Check items added to your cart.</p>
            <a href="my_cart.php">Go to Cart</a>
        </div>

        <div class="card">
            <h3>My Orders</h3>
            <p>Track your previous purchases.</p>
            <a href="my_orders.php">View Orders</a>
        </div>

        <div class="card">
            <h3>My Profile</h3>
            <p>Manage your account details.</p>
            <a href="my_profile.php">Edit Profile</a>
        </div>

    </div>

</div>

</body>
</html>
