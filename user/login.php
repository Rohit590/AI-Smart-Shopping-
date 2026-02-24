<?php
session_start();
include("../includes/db.php");

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password'])){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            header("Location: dashboard.php");
        }
        else{
            echo "Incorrect Password";
        }
    }
    else{
        echo "User not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

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

        /* LOGIN FORM */
        .login-container{
            width:360px;
            padding:35px;
            border-radius:12px;

            background:#0a0f23;
            color:white;

            box-shadow:0 15px 35px rgba(0,0,0,0.15);

            text-align:center;
        }

        /* TITLE */
        .login-container h2{
            margin-bottom:10px;
            font-weight:600;
        }

        /* REGISTER LINK */
        .login-container a{
            color:#fae4cf;
            text-decoration:none;
            font-weight:600;
        }

        .login-container a:hover{
            text-decoration:underline;
        }

        /* INPUT GROUP */
        .input-group{
            margin-top:18px;
        }

        /* INPUT FIELDS */
        .input-group input{
            width:100%;
            padding:12px;
            border-radius:6px;
            border:1px solid rgba(255,255,255,0.2);

            background:transparent;
            color:white;
            font-size:14px;
            outline:none;

            transition:0.25s;
        }

        /* FLOAT EFFECT WHILE TYPING */
        .input-group input:focus{
            border-color:#fae4cf;
            box-shadow:0 0 0 2px rgba(250,228,207,0.2);
        }

        /* PLACEHOLDER */
        .input-group input::placeholder{
            color:#bbb;
        }

        /* LOGIN BUTTON */
        .login-btn{
            width:100%;
            margin-top:20px;
            padding:12px;

            border:none;
            border-radius:6px;

            background:#fae4cf;
            color:#0a0f23;

            font-weight:600;
            cursor:pointer;

            transition:0.25s;
        }

        .login-btn:hover{
            background:#f3d6b9;
        }

        .input-group{
            position:relative;
            margin-top:20px;
        }

        /* Input */
        .input-group input{
            width:100%;
            padding:14px 12px;
            border-radius:6px;
            border:1px solid rgba(255,255,255,0.2);
            background:transparent;
            color:white;
            font-size:14px;
            outline:none;
        }

        /* Label (acts like placeholder) */
        .input-group label{
            position:absolute;
            left:12px;
            top:14px;
            color:#bbb;
            font-size:14px;
            pointer-events:none;
            transition:0.25s ease;
            background:#0a0f23;
            padding:0 4px;
        }

        /* FLOAT EFFECT */
        .input-group input:focus + label,
        .input-group input:valid + label{
            top:-8px;
            font-size:12px;
            color:#fae4cf;
        }

        /* Focus border */
        .input-group input:focus{
            border-color:#fae4cf;
        }


        .input-group{
            position:relative;
            margin-top:24px;
        }

        /* INPUT */
        .input-group input{
            width:100%;
            padding:14px 0 10px 0;
            border:none;
            border-bottom:1px solid rgba(255,255,255,0.25);
            background:transparent;
            color:white;
            font-size:15px;
            outline:none;
        }

        /* LABEL */
        .input-group label{
            position:absolute;
            left:0;
            top:14px;
            color:#bbb;
            font-size:14px;
            pointer-events:none;
            transition:0.3s ease;
        }

        /* FLOAT LABEL */
        .input-group input:focus + label,
        .input-group input:valid + label{
            top:-8px;
            font-size:12px;
            color:#fae4cf;
        }

        /* ANIMATED BORDER */
        .focus-border{
            position:absolute;
            bottom:0;
            left:0;
            width:0%;
            height:2px;
            background:#fae4cf;
            transition:0.35s ease;
        }

        /* BORDER ANIMATION */
        .input-group input:focus ~ .focus-border{
            width:100%;
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

<a href="../index.php" class="home-btn">← Home</a>

<div class="login-container" id="loginBox">
    <h2>Welcome Back 👋</h2>
    Don't have account ?
    <a href="register.php">Register</a>
    

    <form method="POST">
        <div class="input-group">
            <input type="email" name="email" required>
            <label>Email Address</label>
        </div>


        <div class="input-group">
            <input type="password" name="password" required>
            <label>Password</label>
        </div>

        <button type="submit" name="login" class="login-btn">
            Login
        </button>

    </form>
</div>

<script>
    gsap.from("#loginBox",{
        opacity:0,
        duration:0.8,
        ease:"power2.out"
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>



</body>
</html>
