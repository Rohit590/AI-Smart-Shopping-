<?php
include("../includes/db.php");

$id = $_GET['id'];

mysqli_query($conn, "
UPDATE admin_requests
SET status='rejected'
WHERE id='$id'
");

header("Location: admin_requests.php");
