<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_POST['user_id'];

mysqli_query($conn,"
DELETE FROM users WHERE id='$user_id'
");

header("Location: user_list.php");
exit();
?>