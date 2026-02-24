<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

$id = $_SESSION['user_id'];

$query = mysqli_query($conn,"SELECT * FROM users WHERE id='$id'");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
<title>My Profile</title>

<style>
body{
    font-family:Arial;
    background:#fae4cf;
}

.profile{
    width:400px;
    margin:60px auto;
    background:white;
    padding:30px;
    border-radius:10px;
}
</style>
</head>

<body>

<div class="profile">
    <h2>My Profile</h2>

    <p><b>Name:</b> <?php echo $user['name']; ?></p>
    <p><b>Email:</b> <?php echo $user['email']; ?></p>
</div>

</body>
</html>
