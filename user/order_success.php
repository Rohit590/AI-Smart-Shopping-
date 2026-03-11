<?php
session_start();

if(!isset($_GET['order_id'])){
    header("Location: dashboard.php");
    exit();
}

$order_id = $_GET['order_id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Order Successful</title>

<style>

:root{
--cream:#fae4cf;
--navy:#0a0f23;
}

body{
margin:0;
font-family:Arial;
background:var(--cream);
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

/* SUCCESS BOX */

.success-box{
background:white;
padding:40px;
border-radius:12px;
text-align:center;
box-shadow:0 10px 30px rgba(0,0,0,0.15);
width:420px;
}

/* CHECK ICON */

.check-circle{
width:90px;
height:90px;
border-radius:50%;
background:#27ae60;
display:flex;
align-items:center;
justify-content:center;
margin:auto;
font-size:45px;
color:white;
}

/* TEXT */

h2{
margin-top:20px;
color:#0a0f23;
}

p{
color:#555;
}

/* BUTTONS */

.btn{
margin-top:20px;
padding:12px 20px;
border:none;
border-radius:6px;
cursor:pointer;
font-weight:bold;
}

.invoice-btn{
background:#0a0f23;
color:#fae4cf;
}

.home-btn{
background:#fae4cf;
color:#0a0f23;
margin-left:10px;
}

</style>

<!-- GSAP -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

</head>

<body>

<div class="success-box" id="successBox">

<div class="check-circle" id="checkIcon">
✔
</div>

<h2>Order Placed Successfully 🎉</h2>

<p>Your order has been confirmed.</p>
<p>Order ID: <b>#<?php echo $order_id; ?></b></p>

<div>

<a href="invoice.php?order_id=<?php echo $order_id; ?>">
<button class="btn invoice-btn">
View Invoice
</button>
</a>

<a href="dashboard.php">
<button class="btn home-btn">
Continue Shopping
</button>
</a>

</div>

</div>

<script>

/* ANIMATION */

gsap.from("#successBox",{
scale:0.7,
opacity:0,
duration:0.6,
ease:"back.out(1.7)"
});

gsap.from("#checkIcon",{
scale:0,
duration:0.5,
delay:0.3,
ease:"elastic.out(1,0.6)"
});

</script>

</body>
</html>