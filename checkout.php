<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
include("../includes/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

$where = [];

/* SEARCH FILTER */
if(isset($_GET['search']) && $_GET['search'] != ""){
    $search = mysqli_real_escape_string($conn,$_GET['search']);
    $where[] = "name LIKE '%$search%'";
}


/* CATEGORY FILTER */
if(isset($_GET['category']) && $_GET['category'] != ""){
    $category = mysqli_real_escape_string($conn,$_GET['category']);
    $where[] = "category='$category'";
}

/* PRICE FILTER */
if(isset($_GET['min_price']) && isset($_GET['max_price'])){
    $min = (int)$_GET['min_price'];
    $max = (int)$_GET['max_price'];
    $where[] = "price BETWEEN $min AND $max";
}

$sql = "SELECT * FROM products";

if(count($where) > 0){
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY id DESC";

$result = mysqli_query($conn,$sql);

$cat_query = "SELECT DISTINCT category FROM products";
$cat_result = mysqli_query($conn,$cat_query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Browse Products</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <style>

    .main-wrapper{
        width:95%;
        margin:auto;
        display:flex;
        gap:25px;
        align-items:flex-start;
    }


    /* FILTER SIDEBAR */
    .filter-box{
        width:220px;
        background:white;
        padding:15px;
        border-radius:10px;
        height:fit-content;
        box-shadow:0 4px 10px rgba(0,0,0,0.08);

        position: sticky;
        top: 90px;
        max-height: 80vh;
        overflow-y: auto;
    }

    .filter-box h3{
        margin-top:0;
        color:#0a0f23;
    }

    .filter-box label{
        display:block;
        margin:6px 0;
    }

    .filter-box button{
        width:100%;
        padding:8px;
        margin-top:10px;
        background:#0a0f23;
        color:white;
        border:none;
        border-radius:5px;
        cursor:pointer;
    }

    /* PRODUCTS AREA */
    .products-area{
        flex:1;
    }

    .container{
        display:grid;
        grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
        gap:20px;
    }


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

    .navbar a.active{
        border-bottom:2px solid #fae4cf;
        padding-bottom:3px;
    }

    /* SEARCH BAR */
    .search-box{
        width:90%;
        margin:20px auto;
        display:flex;
        justify-content:center;
    }

    .search-box input{
        width:400px;
        padding:10px;
        border-radius:6px 0 0 6px;
        border:1px solid #ccc;
        outline:none;
    }

    .search-box button{
        background:var(--navy);
        color:white;
        border:none;
        padding:10px 20px;
        border-radius:0 6px 6px 0;
        cursor:pointer;
    }

    /* PRODUCT GRID */
    .container{
        width:90%;
        margin:auto;
        display:grid;
        grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
        gap:20px;
    }

    /* PRODUCT CARD */
    .card{
        background:white;
        padding:15px;
        border-radius:10px;
        box-shadow:0 5px 15px rgba(0,0,0,0.08);
        transition:0.2s;
    }

    .card:hover{
        box-shadow:0 8px 20px rgba(0,0,0,0.15);
    }

    .card img{
        width:100%;
        height:180px;
        object-fit:contain;
        background:#fff;
        border-radius:6px;
        padding:8px;
    }


    .card h3{
        margin:10px 0 5px;
        font-size:16px;
        color:var(--navy);
    }

    .price{
        font-weight:bold;
        margin-bottom:10px;
    }

    .add-btn{
        width:100%;
        padding:8px;
        background:var(--navy);
        color:white;
        border:none;
        border-radius:6px;
        cursor:pointer;
    }

    .add-btn:hover{
        background:#151b3a;
    }

    .cart-popup{
        position:fixed;
        top:20px;
        right:20px;
        background:#0a0f23;
        color:#fae4cf;
        padding:14px 20px;
        border-radius:8px;
        box-shadow:0 8px 20px rgba(0,0,0,0.15);
        font-weight:600;
        opacity:0;
        transform:translateY(-20px);
        z-index:999;
    }

    .cart-popup{
        position:fixed;
        top:20px;
        right:-350px;
        width:300px;
        background:white;
        border-radius:10px;
        box-shadow:0 10px 30px rgba(0,0,0,0.15);
        display:flex;
        gap:12px;
        padding:12px;
        z-index:999;
    }

    .popup-left img{
        width:60px;
        height:60px;
        object-fit:cover;
        border-radius:6px;
    }

    .popup-right h4{
        margin:0;
        color:#0a0f23;
    }

    .popup-right p{
        margin:5px 0 10px;
        font-size:13px;
        color:#555;
    }

    .go-cart-btn{
        background:#0a0f23;
        color:#fae4cf;
        text-decoration:none;
        padding:6px 10px;
        border-radius:5px;
        font-size:13px;
    }


    </style>
</head>

<body>

<?php if(isset($_GET['added'])){ ?>
<div id="cart-popup" class="cart-popup">

    <div class="popup-left">
        <img src="../assets/images/<?php echo $_GET['img']; ?>">
    </div>

    <div class="popup-right">
        <h4>✅ Added to Cart</h4>
        <p><?php echo $_GET['name']; ?></p>

        <a href="my_cart.php" class="go-cart-btn">
            Go to Cart →
        </a>
    </div>

</div>
<?php } ?>


<?php if(isset($_GET['added'])){ ?>
    <div id="cart-popup" class="cart-popup">
        ✅ Product added to cart
    </div>
<?php } ?>


<!-- NAVBAR -->
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


<!-- SEARCH BAR -->
<div class="search-box">
    <form method="GET">
        <input type="text" name="search"
               placeholder="Search for products..."
               value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

        <button type="submit">Search</button>
    </form>
</div>


<h2 style="text-align:center;color:#0a0f23;">Browse Products</h2>

<div class="main-wrapper">

    <!-- FILTER SIDEBAR -->
    <form class="filter-box" method="GET">

        <h3>Filters</h3>

        <h4>Category</h4>

        <?php while($cat=mysqli_fetch_assoc($cat_result)){ ?>
            <label>
                <input type="radio" name="category"
                    value="<?php echo $cat['category']; ?>">
                <?php echo $cat['category']; ?>
            </label>
        <?php } ?>

        <h4>Price</h4>
        <input type="number" name="min_price" placeholder="Min Price">
        <input type="number" name="max_price" placeholder="Max Price">

        <button type="submit">Apply Filters</button>
        <a href="browse_products.php">Clear Filters</a>

    </form>


    <!-- PRODUCTS -->
    <div class="products-area">
        <div class="container">

        <?php while($row=mysqli_fetch_assoc($result)){ ?>
            <div class="card">

                <a href="../product.php?id=<?php echo $row['id']; ?>">
                    <img src="../assets/images/<?php echo $row['image']; ?>">
                </a>

                <h3><?php echo $row['name']; ?></h3>
                <p class="price">₹ <?php echo $row['price']; ?></p>

                <form method="POST" action="../add_to_cart.php">
                    <input type="hidden" name="product_id"
                        value="<?php echo $row['id']; ?>">

                    <button type="submit" class="add-btn">
                        Add to Cart
                    </button>
                </form>

            </div>
        <?php } ?>

        </div>
    </div>

</div>


<script>
if(document.getElementById("cart-popup")){
    gsap.to("#cart-popup",{
        opacity:1,
        y:0,
        duration:0.4
    });

    gsap.to("#cart-popup",{
        opacity:0,
        y:-20,
        delay:2,
        duration:0.4
    });
}
</script>

<script>
if(document.getElementById("cart-popup")){

    gsap.to("#cart-popup",{
        right:20,
        duration:0.5,
        ease:"power3.out"
    });

    gsap.to("#cart-popup",{
        right:-350,
        delay:3,
        duration:0.5
    });

}
</script>


</body>
</html>
