<?php include 'config.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>My Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>🛒 My E-commerce Store</h1>

<div class="products">

<?php
$result = $conn->query("SELECT * FROM products");

while($row = $result->fetch_assoc()){
?>

    <div class="product">
        <h3><?php echo $row['name']; ?></h3>
        <p>KES <?php echo $row['price']; ?></p>
        <a href="cart.php?id=<?php echo $row['id']; ?>">Add to Cart</a>
    </div>

<?php } ?>

</div>

<a href="admin.php" class="admin-btn">Go to Admin Panel</a>

</body>
</html>