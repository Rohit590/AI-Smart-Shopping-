


<?php
include("../includes/db.php");

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = "SELECT * FROM admins WHERE email='$email'";
    $result = mysqli_query($conn,$check);

    if(mysqli_num_rows($result) > 0){
        $error = "Email already exists";
    }
    else{
        $query = "INSERT INTO admins(name,email,password)
                  VALUES('$name','$email','$password')";

        if(mysqli_query($conn,$query)){
            $success = "Admin registered successfully";
        } else {
            $error = "Registration failed";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Register</title>

    <style>

    body{
        margin:0;
        height:100vh;
        font-family: Arial, sans-serif;
        background:#fae4cf;

        display:flex;
        justify-content:center;
        align-items:center;
    }

    .admin-box{
        width:380px;
        background:#0a0f23;
        padding:35px;
        border-radius:10px;
        color:white;
        box-shadow:0 10px 25px rgba(0,0,0,0.15);
    }

    .admin-box h2{
        text-align:center;
        margin-bottom:25px;
        color:#fae4cf;
    }

    .input-group{
        position:relative;
        margin-bottom:20px;
    }

    .input-group input{
        width:100%;
        padding:12px;
        border-radius:6px;
        border:none;
        outline:none;
        background:rgba(255,255,255,0.08);
        color:white;
        font-size:14px;
    }

    .input-group label{
        position:absolute;
        left:12px;
        top:12px;
        color:#ccc;
        font-size:14px;
        pointer-events:none;
        transition:0.2s;
    }

    .input-group input:focus + label,
    .input-group input:valid + label{
        top:-8px;
        font-size:12px;
        color:#fae4cf;
    }

    .register-btn{
        width:100%;
        padding:12px;
        background:#fae4cf;
        border:none;
        border-radius:6px;
        font-weight:600;
        cursor:pointer;
        color:#0a0f23;
    }

    .register-btn:hover{
        background:#f3d6bb;
    }

    .error{
        color:#ffb3b3;
        text-align:center;
        margin-bottom:10px;
    }

    .success{
        color:#b8ffb8;
        text-align:center;
        margin-bottom:10px;
    }

    /* REGISTER LINK */
    .admin-box a{
        color:#fae4cf;
        text-decoration:none;
        font-weight:600;
    }

    .admin-box a:hover{
        text-decoration:underline;
    }

    .home-btn{
        position:fixed;
        top:20px;
        left:20px;

        background:#0a0f23;
        color:#fae4cf;

        padding:8px 14px;
        border-radius:6px;
        text-decoration:none;
        font-weight:600;
        font-size:14px;

        box-shadow:0 4px 10px rgba(0,0,0,0.15);
        transition:0.25s;
    }

    .home-btn:hover{
        background:#151b3a;
    }

    </style>
</head>

<body>
    <a href="../index.php" class="home-btn">←Home</a>

<div class="admin-box">

    <h2>Admin Registration</h2>
    Already have account ?
    <a href="login.php">Login</a>

    <?php if(isset($error)){ ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <?php if(isset($success)){ ?>
        <div class="success"><?php echo $success; ?></div>
    <?php } ?>

    <form method="POST">

        <div class="input-group">
            <input type="text" name="name" required>
            <label>Name</label>
        </div>

        <div class="input-group">
            <input type="email" name="email" required>
            <label>Email</label>
        </div>

        <div class="input-group">
            <input type="password" name="password" required>
            <label>Password</label>
        </div>

        <button type="submit" name="register" class="register-btn">
            Register Admin
        </button>

    </form>

</div>

</body>
</html>
