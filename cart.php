<?php include 'config.php'; ?>

<?php
$product = null;

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM products WHERE id=$id");
    $product = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>🛒 Your Cart</h2>

<?php if($product){ ?>
    <div class="product">
        <h3><?php echo $product['name']; ?></h3>
        <p>KES <?php echo $product['price']; ?></p>
    </div>
<?php } else { ?>
    <p>No product selected</p>
<?php } ?>

<a href="index.php">Back to Shop</a>

</body>
</html>