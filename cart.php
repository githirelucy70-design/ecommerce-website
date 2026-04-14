<?php
session_start();
include 'config.php';

// Add to cart
if (isset($_POST['add_to_cart'])) {
    $id    = $_POST['product_id'];
    $name  = $_POST['product_name'];
    $price = $_POST['product_price'];

    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    if (!isset($_SESSION['cart_items'])) $_SESSION['cart_items'] = [];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['cart'][$id] = 1;
        $_SESSION['cart_items'][$id] = ['name' => $name, 'price' => $price];
    }
    header("Location: index.php?msg=Item added to cart!");
    exit;
}

// Remove from cart
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    unset($_SESSION['cart_items'][$id]);
    header("Location: cart.php");
    exit;
}

// Clear cart
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    $_SESSION['cart_items'] = [];
    header("Location: cart.php");
    exit;
}

$cart       = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$cart_items = isset($_SESSION['cart_items']) ? $_SESSION['cart_items'] : [];
$total      = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Cart — Lucy's Tech Shop</title>
<link rel="stylesheet" href="style.css"/>
</head>
<body>

<nav class="navbar">
  <div class="nav-inner">
    <a href="index.php" class="nav-logo">Lucy's Tech Shop</a>
    <div class="nav-links">
      <a href="index.php" class="admin-btn">Back to Shop</a>
      <a href="admin.php" class="admin-btn">Admin</a>
    </div>
  </div>
</nav>

<div class="container" style="margin-top:2rem;">
  <h2 class="section-title">Your Shopping Cart</h2>

  <?php if (empty($cart)): ?>
    <div class="empty-cart">
      <p>Your cart is empty.</p>
      <a href="index.php" class="add-btn">Continue Shopping</a>
    </div>
  <?php else: ?>
    <table class="cart-table">
      <thead>
        <tr>
          <th>Product</th>
          <th>Price</th>
          <th>Qty</th>
          <th>Subtotal</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cart as $id => $qty):
          $item    = $cart_items[$id];
          $subtotal = $item['price'] * $qty;
          $total   += $subtotal;
        ?>
        <tr>
          <td><?php echo htmlspecialchars($item['name']); ?></td>
          <td>KSh <?php echo number_format($item['price'], 2); ?></td>
          <td><?php echo $qty; ?></td>
          <td>KSh <?php echo number_format($subtotal, 2); ?></td>
          <td><a href="cart.php?remove=<?php echo $id; ?>" class="remove-btn">Remove</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3"><strong>Total</strong></td>
          <td colspan="2"><strong>KSh <?php echo number_format($total, 2); ?></strong></td>
        </tr>
      </tfoot>
    </table>
    <div style="margin-top:1rem; display:flex; gap:1rem;">
      <a href="cart.php?clear=1" class="remove-btn" style="padding:10px 20px;">Clear Cart</a>
      <button class="add-btn" onclick="alert('Order placed! Thank you for shopping with us.')">Checkout</button>
    </div>
  <?php endif; ?>
</div>

<footer>
  <p>Lucy's Tech Shop &copy; 2026 &mdash; Built with PHP &amp; MySQL &mdash; Lucy Wairimu Githire</p>
</footer>

</body>
</html>