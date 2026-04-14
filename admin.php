<?php include 'config.php'; ?>

<?php
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $price = $_POST['price'];

    $conn->query("INSERT INTO products (name, price) VALUES ('$name', '$price')");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Admin Panel - Add Product</h2>

<form method="POST" class="form">
    <input type="text" name="name" placeholder="Product Name" required>
    <input type="number" name="price" placeholder="Price" required>
    <button name="add">Add Product</button>
</form>

<a href="index.php">Back to Shop</a>

</body>
</html>