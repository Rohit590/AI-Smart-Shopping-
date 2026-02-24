<?php
session_start();
include("includes/db.php");

$product_query = "SELECT * FROM products ORDER BY id DESC";
$product_result = mysqli_query($conn,$product_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>AI Smart Shopping</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <style>
        :root{
            --cream: #fae4cf;
            --navy: #0a0f23;
            --navy-light: #151b3a;
        }


        .navbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:16px 40px;
            background:var(--navy);
            color:white;

            position:sticky;
            top:0;
            z-index:1000;
        }

        .nav-links{
            display:flex;
            gap:15px;
        }

        .nav-links a{
            background:#fae4cf;
            color:#0a0f23 !important;   

            text-decoration:none;
            padding:8px 22px;
            border-radius:40px;

            font-weight:600;
            font-size:14px;

            display:inline-block;
            transition:0.25s ease;
        }


        /* Hover effect */
        .nav-links a:hover{
            background:#f3d6bb;
        }

        .navbar a{
            color:var(--cream);
            text-decoration:none;
            margin-left:20px;
            font-weight:600;
        }

        .navbar a:hover{
            opacity:0.8;
        }

        body{
            font-family: Arial, sans-serif;
            background: var(--cream);
            margin:0;
            padding-top:0;
        }

        .container{
            width:90%;
            margin:auto;
            display:flex;
            flex-wrap:wrap;
            gap:25px;
            justify-content:center;
        }

        .product-card{
            opacity: 1;
            background:white;
            width:230px;
            padding:15px;
            border-radius:10px;
            box-shadow:0 6px 18px rgba(0,0,0,0.08);
            transition:0.25s ease;
        }

        .product-card:hover{
            box-shadow:0 12px 28px rgba(0,0,0,0.12);
        }


        .product-card img{
            width:100%;
            height:200px;
            object-fit:contain;
            background:#fff;
        }


        .product-card:hover img{
            transform:scale(1.05);
        }


        .product-card h3{
            font-size:18px;
        }

        .product-card button{
            background:var(--navy);
            color:white;
            border:none;
            padding:8px 12px;
            border-radius:6px;
            cursor:pointer;
            transition:0.2s;
        }

        .product-card button:hover{
            background:var(--navy-light);
        }

        .trending-title{
            color:#ff4d4d;
            font-weight:bold;
        }

        .trending-badge{
            background: var(--navy);
            color: var(--cream);
            color:white;
            padding:3px 6px;
            border-radius:4px;
            font-size:11px;
            display:inline-block;
            margin-bottom:5px;
        }

        .ai-section-title{
            text-align:center;
            font-size:24px;
            margin-top:35px;
            margin-bottom:20px;
            color:var(--navy);
            letter-spacing:0.5px;
        }

        .logo h3{
            margin:0;
        }

        .nav-links a{
            margin-left:20px;
        }

        .hero{
            text-align:center;
            padding:60px 20px;
            background:white;
        }

        .hero h1{
            color:var(--navy);
            margin-bottom:10px;
        }

        .hero p{
            color:#555;
        }

        .shop-btn{
            display:inline-block;
            margin-top:15px;
            padding:10px 20px;
            background:var(--navy);
            color:white;
            text-decoration:none;
            border-radius:6px;
        }

        .about{
            background:white;
            padding:50px 20px;
            text-align:center;
            margin-top:40px;
        }

        .about h2{
            color:var(--navy);
        }

        .footer{
            background:var(--navy);
            color:white;
            text-align:center;
            padding:15px;
            margin-top:40px;
        }


    </style>
</head>

<body>
    <div class="navbar">

        <div class="logo">
            <h3>AI Smart Shopping🤖🛒</h3>
        </div>

        <div class="nav-links">
            <a href="index.php">Home</a>
                <a href="user/login.php">Login</a>
                <a href="user/register.php">Register</a>
            <a href="admin/login.php">Admin</a>
        </div>

    </div>


    <div class="hero">
        <h1>Smart Shopping Powered by AI</h1>
        <p>Discover products recommended specially for you.</p>
        <a href="#products" class="shop-btn">Shop Now</a>
    </div>



    <div style="text-align:center; margin:20px;">
        <input type="text" id="search" placeholder="Search products..."
            style="width:300px; padding:8px; border-radius:6px; border:1px solid #ccc;">
    </div>

    <div id="search-results" class="container"></div>


<h2 class="ai-section-title">🔥 AI Trending Products</h2>
<div class="container">

<?php
    $trend_query = "
    SELECT products.*, COUNT(user_activity.product_id) as total_views
    FROM user_activity
    JOIN products ON user_activity.product_id = products.id
    GROUP BY user_activity.product_id
    ORDER BY total_views DESC
    LIMIT 4
    ";

    $trend_result = mysqli_query($conn,$trend_query);

    while($trend = mysqli_fetch_assoc($trend_result)){
    ?>

    <div class="product-card">
        <a href="product.php?id=<?php echo $trend['id']; ?>">
            <img src="assets/images/<?php echo $trend['image']; ?>">
        </a>

        <span class="trending-badge">🔥 Trending</span>
        <h3><?php echo $trend['name']; ?></h3>
        <p>₹ <?php echo $trend['price']; ?></p>
    </div>

    <?php } ?>

    </div>


<h2 id="products" class="ai-section-title">🛍️ Our Products</h2>

<div class="container">

<?php while($row = mysqli_fetch_assoc($product_result)){ ?>

    <div class="product-card">
        <a href="product.php?id=<?php echo $row['id']; ?>">
            <img src="assets/images/<?php echo $row['image']; ?>">
        </a>
        <h3><?php echo $row['name']; ?></h3>
        <p>₹ <?php echo $row['price']; ?></p>
        <button>Add to Cart</button>
    </div>

<?php } ?>

</div>

<div class="about">
    <h2>About AI Smart Shopping🤖🛒</h2>
    <p>
        AI Smart Shopping is an intelligent ecommerce platform that recommends
        products based on user activity and shopping behavior. Our system helps
        users discover relevant products faster using AI-driven insights.
    </p>
</div>


<script>
    gsap.registerPlugin(ScrollTrigger);

    gsap.utils.toArray(".product-card").forEach(card => {

    gsap.from(card,{
        scrollTrigger:{
            trigger: card,
            start: "top 85%",
            toggleActions: "play none none none"
        },
        opacity:0,
        y:40,
        duration:0.6,
        ease:"power2.out"
    });

});

</script>



<script>
document.getElementById("search").addEventListener("keyup", function(){

    let value = this.value;

    if(value.length == 0){
        document.getElementById("search-results").innerHTML = "";
        return;
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "search.php", true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    xhr.onload = function(){
        document.getElementById("search-results").innerHTML = this.responseText;
    }

    xhr.send("search=" + value);
});
</script>


<div class="footer">
    <p>© 2026 AI Smart Shopping | All Rights Reserved</p>
</div>

</body>
</html>
