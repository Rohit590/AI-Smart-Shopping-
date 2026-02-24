<?php
include("includes/db.php");

if(isset($_POST['search'])){

    $search = $_POST['search'];

    $query = "SELECT * FROM products
              WHERE name LIKE '%$search%'
              LIMIT 6";

    $result = mysqli_query($conn,$query);

    while($row = mysqli_fetch_assoc($result)){
?>

<div class="product-card">
    <a href="product.php?id=<?php echo $row['id']; ?>">
        <img src="assets/images/<?php echo $row['image']; ?>">
    </a>
    <h3><?php echo $row['name']; ?></h3>
    <p>₹ <?php echo $row['price']; ?></p>
</div>

<?php
    }
}
?>
