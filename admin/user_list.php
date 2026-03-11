<?php
session_start();
include("../includes/db.php");

/* ADMIN LOGIN CHECK */

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

/* GET ALL USERS */

$users = mysqli_query($conn,"
SELECT * FROM users
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>User List</title>

<style>

:root{
--cream:#fae4cf;
--navy:#0a0f23;
}

/* BODY */

body{
margin:0;
font-family:Arial;
background:var(--cream);
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

/* CONTAINER */

.container{
width:85%;
margin:40px auto;
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 10px 20px rgba(0,0,0,0.1);
}

/* TABLE */

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

th{
background:var(--navy);
color:white;
padding:12px;
text-align:left;
}

td{
padding:12px;
border-bottom:1px solid #ddd;
}

tr:hover{
background:#f5f5f5;
}

/* DELETE BUTTON */

.delete-btn{
background:#e74c3c;
color:white;
border:none;
padding:6px 12px;
border-radius:5px;
cursor:pointer;
}

.delete-btn:hover{
background:#c0392b;
}

</style>

</head>

<body>

<div class="navbar">
<h3>Admin Panel</h3>

<div>
<a href="dashboard.php">Dashboard</a>
<a href="manage_product.php">Products</a>
<a href="logout.php">Logout</a>
</div>

</div>

<div class="container">

<h2>Registered Users</h2>

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Action</th>
</tr>

<?php while($user = mysqli_fetch_assoc($users)){ ?>

<tr>

<td><?php echo $user['id']; ?></td>

<td><?php echo $user['name']; ?></td>

<td><?php echo $user['email']; ?></td>

<td>

<form method="POST" action="delete_user.php">

<input type="hidden" name="user_id"
value="<?php echo $user['id']; ?>">

<button class="delete-btn">
Delete
</button>

</form>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>