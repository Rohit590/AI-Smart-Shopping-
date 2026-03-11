<?php
include("../includes/db.php");
$success = false;

if(isset($_POST['add_product'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);


    $image = $_FILES['image']['name'];
    $temp_name = $_FILES['image']['tmp_name'];

    move_uploaded_file($temp_name,"../assets/images/".$image);

    $query = "INSERT INTO products(name,price,description,image,category)
              VALUES('$name','$price','$description','$image','$category')";

    $success = false;

    if(mysqli_query($conn,$query)){
        $success = true;
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>

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
        width:420px;
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
        margin-bottom:18px;
    }

    .input-group input,
    .input-group textarea{
        width:100%;
        padding:12px;
        border-radius:6px;
        border:none;
        outline:none;
        background:rgba(255,255,255,0.08);
        color:white;
        font-size:14px;
    }

    .input-group textarea{
        resize:none;
        height:80px;
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
    .input-group input:valid + label,
    .input-group textarea:focus + label,
    .input-group textarea:valid + label{
        top:-8px;
        font-size:12px;
        color:#fae4cf;
    }

    /* File input */
    .file-input{
        margin-bottom:18px;
        font-size:14px;
    }

    .file-input input{
        color:white;
    }

    .add-btn{
        width:100%;
        padding:12px;
        background:#fae4cf;
        border:none;
        border-radius:6px;
        font-weight:600;
        cursor:pointer;
        color:#0a0f23;
        transition:0.2s;
    }

    .add-btn:hover{
        background:#f3d6bb;
    }

    .back-btn{
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

    .back-btn:hover{
        background:#151b3a;
    }

    .popup-success{
        position:fixed;
        top:30px;
        right:30px;
        background:#0a0f23;
        color:#fae4cf;
        padding:14px 20px;
        border-radius:8px;
        box-shadow:0 6px 20px rgba(0,0,0,0.2);
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

    </style>
</head>

<body>

<a href="dashboard.php" class="back-btn">← Dashboard</a>

<div class="admin-box">

    <h2>Add Product</h2>

    <form method="POST" enctype="multipart/form-data">

        <div class="input-group">
            <input type="text" name="name" required>
            <label>Product Name</label>
        </div>

        <div class="input-group">
            <input type="number" name="price" required>
            <label>Price</label>
        </div>

        <div class="input-group">
            <input type="text" name="category" required>
            <label>Category</label>
        </div>

        <div class="input-group">
            <textarea name="description" required></textarea>
            <label>Description</label>
        </div>

        <div class="file-input">
            Product Image:<br>
            <input type="file" name="image" required>
        </div>

        <button type="submit" name="add_product" class="add-btn">
            Add Product
        </button>

    </form>

</div>

<?php if($success){ ?>
<div class="popup-success" id="successPopup">
    ✅ Product Added Successfully
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


</body>
</html>

