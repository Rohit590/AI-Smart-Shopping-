<?php
include("../includes/db.php");

$id = $_GET['id'];

$request = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT * FROM admin_requests WHERE id='$id'
"));

$name = $request['name'];
$email = $request['email'];
$password = $request['password'];

mysqli_query($conn, "
INSERT INTO admins(name,email,password)
VALUES('$name','$email','$password')
");

mysqli_query($conn, "
UPDATE admin_requests SET status='approved'
WHERE id='$id'
");

header("Location: admin_requests.php");
