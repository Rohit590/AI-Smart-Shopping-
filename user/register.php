<?php
include("../includes/db.php");
$success = false;
$registered_name = "";

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (name,email,password)
              VALUES ('$name','$email','$password')";

    if(mysqli_query($conn,$query)){
        $success = true;
        $registered_name = $name;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

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

    /* REGISTER FORM */
    .register-container{
        width:360px;
        padding:35px;
        border-radius:12px;

        background:#0a0f23;
        color:white;

        box-shadow:0 15px 35px rgba(0,0,0,0.15);
        text-align:center;
    }

    .register-container h2{
        margin-bottom:10px;
        font-weight:600;
    }

    .register-container a{
        color:#fae4cf;
        text-decoration:none;
        font-weight:600;
    }

    .register-container a:hover{
        text-decoration:underline;
    }

    /* INPUT GROUP */
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

    /* AI STYLE GLOW */
    .input-group input:focus{
        box-shadow:
            0 2px 0 #fae4cf,
            0 6px 14px rgba(250,228,207,0.15);
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

    .input-group input:focus ~ .focus-border{
        width:100%;
    }

    /* BUTTON */
    .register-btn{
        width:100%;
        margin-top:25px;
        padding:12px;
        border:none;
        border-radius:6px;

        background:#fae4cf;
        color:#0a0f23;

        font-weight:600;
        cursor:pointer;
        transition:0.25s;
    }

    .register-btn:hover{
        background:#f3d6b9;
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

    /* SUCCESS POPUP */
    .popup-success{
        position:fixed;
        top:30px;
        right:30px;
        background:#0a0f23;
        color:#fae4cf;
        padding:14px 22px;
        border-radius:8px;
        box-shadow:0 8px 20px rgba(0,0,0,0.2);
        font-weight:600;
        z-index:9999;
        animation: slideIn 0.4s ease;
    }

    @keyframes slideIn{
        from{
            transform:translateX(100px);
            opacity:0;
        }
        to{
            transform:translateX(0);
            opacity:1;
        }
    }

    /* PREMIUM SUCCESS POPUP */
.popup-success{
    position:fixed;
    top:25px;
    right:-350px;
    width:300px;
    background:#0a0f23;
    color:#fae4cf;
    padding:16px;
    border-radius:10px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
    z-index:9999;
    display:flex;
    gap:12px;
    align-items:center;
}

/* icon */
.popup-icon{
    font-size:26px;
}

/* text */
.popup-content h4{
    margin:0;
    font-size:15px;
}

.popup-content p{
    margin:4px 0 0;
    font-size:13px;
    color:#ddd;
}

/* progress bar */
.popup-progress{
    position:absolute;
    bottom:0;
    left:0;
    height:3px;
    background:#fae4cf;
    width:100%;
    animation: progressBar 3s linear forwards;
}

@keyframes progressBar{
    from{ width:100%; }
    to{ width:0%; }
}



    </style>
</head>

<body>

<a href="../index.php" class="home-btn">← Home</a>

<div class="register-container">
    <h2>Create Account</h2>
    Already have account?
    <a href="login.php">Login</a>

    <form method="POST">

        <div class="input-group">
            <input type="text" name="name" required>
            <label>Full Name</label>
            <span class="focus-border"></span>
        </div>

        <div class="input-group">
            <input type="email" name="email" required>
            <label>Email Address</label>
            <span class="focus-border"></span>
        </div>

        <div class="input-group">
            <input type="password" name="password" required>
            <label>Password</label>
            <span class="focus-border"></span>
        </div>

        <button type="submit" name="register" class="register-btn">
            Register
        </button>

    </form>
</div>

<?php if($success){ ?>
<div class="popup-success" id="successPopup">
    ✅ Registration Successful
</div>
<?php } ?>

<script>
setTimeout(()=>{
    let popup = document.getElementById("successPopup");
    if(popup){
        popup.style.opacity = "0";
        popup.style.transition = "0.4s";
        setTimeout(()=>popup.remove(),400);
    }
},2500);
</script>

<?php if($success){ ?>
<div class="popup-success" id="successPopup">

    <div class="popup-icon">✅</div>

    <div class="popup-content">
        <h4>Welcome, <?php echo $registered_name; ?>!</h4>
        <p>Registration successful</p>
    </div>

    <div class="popup-progress"></div>

</div>
<?php } ?>

<?php if($success){ ?>
<script>
let popup = document.getElementById("successPopup");

if(popup){

    /* slide in */
    setTimeout(()=>{
        popup.style.right = "20px";
        popup.style.transition = "0.5s ease";
    },100);

    /* auto close */
    setTimeout(()=>{
        popup.style.opacity = "0";
        popup.style.right = "-350px";
    },2800);

    /* redirect to login */
    setTimeout(()=>{
        window.location.href = "login.php";
    },3000);
}
</script>
<?php } ?>

</body>
</html>

</body>
</html>

