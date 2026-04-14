<?php
session_start();
include 'config.php';

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

if ($search) {
    $result = mysqli_query($conn, "SELECT * FROM products WHERE name LIKE '%$search%' OR description LIKE '%$search%'");
} else {
    $result = mysqli_query($conn, "SELECT * FROM products");
}

$cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Lucy's Tech Shop</title>
<link rel="stylesheet" href="style.css"/>
</head>
<body>

<nav class="navbar">
  <div class="nav-inner">
    <a href="index.php" class="nav-logo">Lucy's Tech Shop</a>
    <div class="nav-links">
      <form method="GET" action="index.php" class="search-form">
        <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>"/>
        <button type="submit">Search</button>
      </form>
      <a href="cart.php" class="cart-btn">Cart <span class="cart-count"><?php echo $cart_count; ?></span></a>
      <a href="admin.php" class="admin-btn">Admin</a>
    </div>
  </div>
</nav>

<div class="hero">
  <h1>Welcome to Lucy's Tech Shop</h1>
  <p>Quality tech products at affordable prices in Nairobi</p>
</div>

<div class="container">
  <h2 class="section-title">Our Products</h2>

  <?php if (isset($_GET['msg'])): ?>
    <div class="alert"><?php echo htmlspecialchars($_GET['msg']); ?></div>
  <?php endif; ?>

  <div class="products-grid">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <div class="product-card">
      <div class="product-img">
        <span><?php echo strtoupper(substr($row['name'], 0, 2)); ?></span>
      </div>
      <div class="product-info">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p class="product-desc"><?php echo htmlspecialchars($row['description']); ?></p>
        <div class="product-footer">
          <span class="price">KSh <?php echo number_format($row['price'], 2); ?></span>
          <span class="stock <?php echo $row['stock'] > 0 ? 'in-stock' : 'out-stock'; ?>">
            <?php echo $row['stock'] > 0 ? "In Stock ({$row['stock']})" : "Out of Stock"; ?>
          </span>
        </div>
        <?php if ($row['stock'] > 0): ?>
        <form method="POST" action="cart.php">
          <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>"/>
          <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['name']); ?>"/>
          <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>"/>
          <button type="submit" name="add_to_cart" class="add-btn">Add to Cart</button>
        </form>
        <?php endif; ?>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>

<footer>
  <p>Lucy's Tech Shop &copy; 2026 &mdash; Built with PHP &amp; MySQL &mdash; Lucy Wairimu Githire</p>
</footer>

</body>
</html>
