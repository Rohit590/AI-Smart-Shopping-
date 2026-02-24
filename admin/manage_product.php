<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

/* DELETE PRODUCT */
$deleted = false;

if(isset($_POST['delete_product'])){
    $id = $_POST['product_id'];

    mysqli_query($conn,"DELETE FROM products WHERE id='$id'");

    $deleted = true;
}

$query = "SELECT * FROM products ORDER BY id";
$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
}

.sidebar a{
    display:block;
    padding:12px 25px;
    color:#fae4cf;
    text-decoration:none;
}

.sidebar a:hover{
    background:#151b3a;
}

/* MAIN CONTENT */
.main{
    margin-left:230px;
    width:100%;
    padding:30px;
}

.header{
    background:white;
    padding:15px;
    border-radius:8px;
    margin-bottom:20px;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
}

/* TABLE */
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
    text-align:left;
    border-bottom:1px solid #eee;
}

th{
    background:#0a0f23;
    color:#fae4cf;
}

img{
    width:60px;
    height:60px;
    object-fit:cover;
    border-radius:6px;
}

.delete-btn{
    background:#d9534f;
    color:white;
    border:none;
    padding:6px 12px;
    border-radius:4px;
    cursor:pointer;
}

.delete-btn:hover{
    background:#c9302c;
}


</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Admin Panel</h2>

    <a href="dashboard.php">Dashboard</a>
    <a href="add_product.php">Add Product</a>
    <a href="manage_products.php">Manage Products</a>
    <a href="logout.php">Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="main">

    <div class="header">
        <h2>Manage Products</h2>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Action</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>

            <td>
                <img src="../assets/images/<?php echo $row['image']; ?>">
            </td>

            <td><?php echo $row['name']; ?></td>
            <td>₹ <?php echo $row['price']; ?></td>
            <td><?php echo $row['category']; ?></td>

            <td>

                <form method="POST" 
                    onsubmit="return confirm('Delete this product?');">

                    <input type="hidden" name="product_id"
                        value="<?php echo $row['id']; ?>">

                    <button type="submit"
                            name="delete_product"
                            class="delete-btn">
                        Delete
                    </button>
                </form>

            </td>

        </tr>
        <?php } ?>

    </table>

</div>

<?php if($deleted){ ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'Product Deleted Successfully',
            confirmButtonColor: '#0a0f23'
        });
    </script>
<?php } ?>

</body>
</html>
