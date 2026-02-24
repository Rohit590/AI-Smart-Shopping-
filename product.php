<?php
session_start();
include("includes/db.php");

$cart_count = 0;
if(isset($_SESSION['user_id'])){
    $uid = $_SESSION['user_id'];
    $count_query = mysqli_query($conn,"SELECT SUM(quantity) as total FROM cart WHERE user_id='$uid'");
    $count_data = mysqli_fetch_assoc($count_query);
    $cart_count = $count_data['total'] ?? 0;
}

$product_id = $_GET['id'];

$query = "SELECT * FROM products WHERE id='$product_id'";
$result = mysqli_query($conn,$query);
$product = mysqli_fetch_assoc($result);

/* AI Activity Tracking */
if(isset($_SESSION['user_id'])){
    /* Add to Cart Logic */
    if(isset($_POST['add_to_cart']) && isset($_SESSION['user_id'])){

        $user_id = $_SESSION['user_id'];

        $check = "SELECT * FROM cart 
                WHERE user_id='$user_id' 
                AND product_id='$product_id'";

        $check_result = mysqli_query($conn,$check);

        if(mysqli_num_rows($check_result) > 0){
            mysqli_query($conn,"UPDATE cart 
                                SET quantity = quantity + 1
                                WHERE user_id='$user_id' 
                                AND product_id='$product_id'");
        }
        else{
            mysqli_query($conn,"INSERT INTO cart(user_id,product_id,quantity)
                                VALUES('$user_id','$product_id',1)");
        }
    }





    $user_id = $_SESSION['user_id'];

    $activity = "INSERT INTO user_activity(user_id,product_id,action_type)
                 VALUES('$user_id','$product_id','view')";
    mysqli_query($conn,$activity);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $product['name']; ?></title>
    <style>
        body{
            margin:0;
            font-family:Arial, sans-serif;
            background:#fae4cf;
        }

        /* NAVBAR */
        .navbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:15px 30px;
            background:#0a0f23;
            color:#fae4cf;
        }

        .navbar a{
            text-decoration:none;
            margin-left:20px;
            color:#fae4cf;
            font-weight:600;
        }

        /* PRODUCT SECTION */
        .product-wrapper{
            width:85%;
            margin:40px auto;
            display:grid;
            grid-template-columns: 1fr 1.2fr;
            gap:60px;
            align-items:start;
        }


        .product-image{
            background:white;
            padding:25px;
            border-radius:12px;
            box-shadow:0 8px 20px rgba(0,0,0,0.08);
        }

        .product-image img{
            width:100%;
            max-width:420px;
            border-radius:10px;
            transition:0.3s;
        }

        .product-image img:hover{
            transform:scale(1.05);
        }

        .product-details{
            background:white;
            padding:30px;
            border-radius:12px;
            box-shadow:0 8px 20px rgba(0,0,0,0.08);
        }

        .product-details h2{
            margin-top:0;
            font-size:26px;
        }

        .price{
            font-size:26px;
            font-weight:bold;
            color:#0a0f23;
            margin:15px 0;
        }

        .add-btn{
            width:100%;
            background:#0a0f23;
            color:#fae4cf;
            border:none;
            padding:14px;
            border-radius:8px;
            cursor:pointer;
            font-weight:bold;
            font-size:15px;
            transition:0.25s;
        }

        .add-btn:hover{
            background:#151b3a;
            transform:translateY(-2px);
        }


        /* RECOMMENDATION */
        .ai-label{
            width:85%;
            margin:40px auto 10px;
            color:#0a0f23;
        }

        .buy-box{
            background:#f8f8f8;
            padding:12px;
            border-radius:8px;
            margin-bottom:15px;
            font-size:14px;
        }


        .recommend-container{
            width:85%;
            margin:auto;
            display:flex;
            gap:20px;
            overflow-x:auto;
            padding-bottom: 10px;
        }

        .recommend-card img{
            width: 100%;
            height: 120px;
            object-fit: contain;
            background:#fff;
        }


        .recommend-card{
            min-width:180px;
            background:white;
            padding:10px;
            border-radius:10px;
            box-shadow:0 4px 10px rgba(0,0,0,0.08);
            text-align:center;
            transition:0.25s;
        }

        .recommend-card:hover{
            transform:translateY(-6px);
        }

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
</head>
<body>
    <div class="navbar">
        <h2>AI Smart Shopping</h2>

        <div>
            <a href="index.php">Home</a>
            <a href="user/my_cart.php">Cart(<?php echo $cart_count; ?>)</a>
        </div>
    </div>

    <div class="product-wrapper">

    <div class="product-image">
        <img src="assets/images/<?php echo $product['image']; ?>">
    </div>

    <div class="product-details">
        <h2><?php echo $product['name']; ?></h2>

        <div class="price">
            ₹ <?php echo $product['price']; ?>
            <div class="buy-box">
                <p>✔ In Stock</p>
                <p>🚚 Free Delivery</p>
            </div>

        </div>

        <p><?php echo $product['description']; ?></p>

        <form method="POST">
            <button type="submit" name="add_to_cart" class="add-btn">
                Add to Cart
            </button>
        </form>
    </div>

</div>
<hr style="width:85%;margin:40px auto;border:none;border-top:1px solid #ddd;">




    <?php
    $recommended_category = "";

    if(isset($_SESSION['user_id'])){

        $user_id = $_SESSION['user_id'];

        $cat_query = "
            SELECT p.category, COUNT(*) as total
            FROM user_activity ua
            JOIN products p ON ua.product_id = p.id
            WHERE ua.user_id = '$user_id'
            GROUP BY p.category
            ORDER BY total DESC
            LIMIT 1
        ";

        $cat_result = mysqli_query($conn,$cat_query);

        if(mysqli_num_rows($cat_result) > 0){
            $row_cat = mysqli_fetch_assoc($cat_result);
            $recommended_category = $row_cat['category'];
        }
    }
    ?> 


    <hr style="width:85%;margin:40px auto;border:none;border-top:1px solid #ddd;">

    <h3 class="ai-label">🤖 AI Recommended For You</h3>

    <div class="recommend-container">

    <?php

    if($recommended_category != ""){
        $rec_query = "SELECT * FROM products
                    WHERE category='$recommended_category'
                    AND id != '$product_id'
                    LIMIT 4";
    }
    else{
        $rec_query = "SELECT * FROM products
                    WHERE category='{$product['category']}'
                    AND id != '$product_id'
                    LIMIT 4";
    }

    $rec_result = mysqli_query($conn,$rec_query);

    while($rec = mysqli_fetch_assoc($rec_result)){
    ?>
    

    <div class="recommend-card">
        <a href="product.php?id=<?php echo $rec['id']; ?>">
            <img src="assets/images/<?php echo $rec['image']; ?>" width="150">
        </a>
        <p><?php echo $rec['name']; ?></p>
        <p>₹ <?php echo $rec['price']; ?></p>

    </div>

    <?php } ?>
    </div>

    <h3 class="ai-label">🧠 Customers Also Bought</h3>

    <div class="recommend-container">

    <?php

        $ai_query = "
        SELECT p.*, COUNT(ua.product_id) as score
        FROM user_activity ua
        JOIN products p ON ua.product_id = p.id
        WHERE ua.product_id != '$product_id'
        AND ua.user_id IN (
            SELECT user_id FROM user_activity
            WHERE product_id='$product_id'
        )
        GROUP BY ua.product_id
        ORDER BY score DESC
        LIMIT 4
        ";

        $ai_result = mysqli_query($conn,$ai_query);

        while($ai = mysqli_fetch_assoc($ai_result)){
        ?>

        <div class="recommend-card">
            <a href="product.php?id=<?php echo $ai['id']; ?>">
                <img src="assets/images/<?php echo $ai['image']; ?>" width="150">
            </a>
            <p><?php echo $ai['name']; ?></p>
            <p>₹ <?php echo $ai['price']; ?></p>
        </div>

    <?php } ?>

    </div>



    <script>
        gsap.from(".product-image",{
            x:-40,
            scale:0.97,
            duration:0.7,
            ease:"power2.out"
        }); 


        gsap.from(".product-details",{
            x:50,
            duration:0.8,
            delay:0.2,
            ease:"power2.out"
        });


        gsap.from(".recommend-card",{
            y:30,
            duration:0.5,
            stagger:0.15,
            ease:"power2.out"
        });

    </script>


</body>
</html>



