<?php
session_start();
include("../includes/db.php");

/* TOTAL PRODUCTS */
$product_data = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) as total FROM products")
);
$total_products = $product_data['total'];

/* TOTAL USERS */
$order_data = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) as total FROM orders")
);
$total_orders = $order_data['total'] ?? 0;

/* TOTAL REVENUE */
$revenue_data = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT SUM(total_amount) as total FROM orders")
);
$total_revenue = $revenue_data['total'] ?? 0;

/* RECENT ORDERS */
$recent_orders = mysqli_query(
    $conn,
    "SELECT orders.*, users.name 
     FROM orders 
     JOIN users ON orders.user_id = users.id
     ORDER BY orders.id DESC
     LIMIT 5"
);


/* RECENT PRODUCTS */
$recent_products = mysqli_query(
    $conn,
    "SELECT * FROM products ORDER BY id DESC LIMIT 5"
);


if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>

    body{
        margin:0;
        font-family: Arial, sans-serif;
        background:#fae4cf;
        display:flex;
    }

    /* SIDEBAR */
    .sidebar{
        width:230px;
        height:100vh;
        background:#0a0f23;
        color:white;
        padding-top:20px;
        position:fixed;
    }

    .sidebar h2{
        text-align:center;
        color:#fae4cf;
        margin-bottom:30px;
    }

    .sidebar a{
        display:block;
        padding:12px 25px;
        color:#fae4cf;
        text-decoration:none;
        transition:0.2s;
    }

    .sidebar a:hover{
        background:#151b3a;
    }

    .sidebar a.active{
        background:#151b3a;
        border-left:4px solid #fae4cf;
        padding-left: 21px;
    }


    .topbar{
        background:white;
        padding:15px 20px;
        border-radius:8px;
        box-shadow:0 4px 10px rgba(0,0,0,0.08);
        margin-bottom:20px;

        display:flex;
        justify-content:space-between;
        align-items:center;
    }

    .admin-info{
        font-weight:600;
    }

    .admin-info a{
        margin-left:15px;
        color:#0a0f23;
        text-decoration:none;
    }

    /* MAIN CONTENT */
    .main{
        margin-left:230px;
        width:100%;
        padding:30px;
    }

    .header{
        background:white;
        padding:15px 20px;
        border-radius:8px;
        box-shadow:0 4px 10px rgba(0,0,0,0.08);
        margin-bottom:20px;
    }

    .card-container{
        display:flex;
        gap:20px;
        flex-wrap:wrap;
    }

    .card{
        background:white;
        padding:20px;
        border-radius:8px;
        width:200px;
        box-shadow:0 4px 10px rgba(0,0,0,0.08);
    }

    .card h3{
        margin:0;
        color:#0a0f23;
    }

    .stats{
        display:flex;
        gap:20px;
        margin-bottom:25px;
    }

    .stat-card{
        background:white;
        padding:20px;
        border-radius:8px;
        width:220px;
        box-shadow:0 4px 10px rgba(0,0,0,0.08);
        transition: 0.25s ease;
    }

    .stat-card:hover{
        transform: translateY(-4px);
        box-shadow: 0 10px 25px egba(0,0,0,0.15);
    }

    .stat-card h3{
        margin:0;
        color:#555;
    }

    .stat-card h2{
        margin-top:10px;
        color:#0a0f23;
    }

    table{
        width:100%;
        border-collapse:collapse;
        background:white;
        border-radius:8px;
        overflow:hidden;
        box-shadow:0 4px 10px rgba(0,0,0,0.08);
    }

    th, td{
        padding:12px;
        border-bottom:1px solid #eee;
    }

    th{
        background:#0a0f23;
        color:#fae4cf;
    }

    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Admin Panel</h2>

    <a href="dashboard.php" class="active">Dashboard</a>
    <a href="add_product.php">Add Product</a>
    <a href="manage_product.php">Manage Products</a>
    <a href="user_list.php">Users</a>
    <a href="logout.php">Logout</a>
</div>


<!-- MAIN CONTENT -->
<div class="main">

    <div class="topbar">
        <h2>Admin Dashboard</h2>

        <div class="admin-info">
            Welcome, <?php echo $_SESSION['admin_name']; ?>
            <a href="logout.php">Logout</a>
        </div>
    </div>


    <div class="stats">

        <div class="stat-card">
            <h3>Total Products</h3>
            <h2><?php echo $total_products; ?></h2>
        </div>

        <div class="stat-card">
            <h3>Total Users</h3>
            <h2><?php echo $total_users; ?></h2>
        </div>

        <div class="stat-card">
            <h3>Total Orders</h3>
            <h2><?php echo $total_orders; ?></h2>
        </div>

        <div class="stat-card">
            <h3>Total Revenue</h3>
            <h2>₹<?php echo $total_revenue; ?></h2>
        </div>

    </div>


    <div class="recent-products">
        <h3>Recently Added Products</h3>

        <table>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
            </tr>

            <?php while($row=mysqli_fetch_assoc($recent_products)){ ?>
            <tr>
                <td>
                    <img src="../assets/images/<?php echo $row['image']; ?>"
                        style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                </td>
                <td><?php echo $row['name']; ?></td>
                <td>₹ <?php echo $row['price']; ?></td>
                <td><?php echo $row['category']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>


</div>

<script>
document.querySelectorAll(".stat-card h2").forEach(counter => {

    let target = parseInt(counter.innerText.replace(/[^\d]/g,''));
    let count = 0;

    let interval = setInterval(() => {
        count += Math.ceil(target / 30);

        if(count >= target){
            counter.innerText = target;
            clearInterval(interval);
        } else {
            counter.innerText = count;
        }

    }, 30);
});
</script>

<script>
const ctx = document.getElementById('salesChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
        datasets: [{
            label: 'Sales',
            data: [1200,1900,800,1500,2000,1700,2200],
            borderColor: '#0a0f23',
            backgroundColor: 'rgba(10,15,35,0.1)',
            tension: 0.4
        }]
    }
});
</script>

</body>
</html>




