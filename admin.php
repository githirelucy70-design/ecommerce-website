<?php
session_start();
include 'config.php';

// Add product
if (isset($_POST['add_product'])) {
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $price = floatval($_POST['price']);
    $desc  = mysqli_real_escape_string($conn, $_POST['description']);
    $stock = intval($_POST['stock']);
    mysqli_query($conn, "INSERT INTO products (name, price, description, stock) VALUES ('$name', $price, '$desc', $stock)");
    header("Location: admin.php?msg=Product added!");
    exit;
}

// Delete product
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: admin.php?msg=Product deleted!");
    exit;
}

// Edit product - load
$edit_product = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
    $edit_product = mysqli_fetch_assoc($res);
}

// Edit product - save
if (isset($_POST['update_product'])) {
    $id    = intval($_POST['id']);
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $price = floatval($_POST['price']);
    $desc  = mysqli_real_escape_string($conn, $_POST['description']);
    $stock = intval($_POST['stock']);
    mysqli_query($conn, "UPDATE products SET name='$name', price=$price, description='$desc', stock=$stock WHERE id=$id");
    header("Location: admin.php?msg=Product updated!");
    exit;
}

$products = mysqli_query($conn, "SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Admin Panel — Lucy's Tech Shop</title>
<link rel="stylesheet" href="style.css"/>
</head>
<body>

<nav class="navbar">
  <div class="nav-inner">
    <a href="index.php" class="nav-logo">Lucy's Tech Shop</a>
    <div class="nav-links">
      <a href="index.php" class="admin-btn">View Shop</a>
    </div>
  </div>
</nav>

<div class="container" style="margin-top:2rem;">
  <h2 class="section-title">Admin Panel — Manage Products</h2>

  <?php if (isset($_GET['msg'])): ?>
    <div class="alert"><?php echo htmlspecialchars($_GET['msg']); ?></div>
  <?php endif; ?>

  <!-- Add / Edit Form -->
  <div class="admin-form">
    <h3><?php echo $edit_product ? 'Edit Product' : 'Add New Product'; ?></h3>
    <form method="POST" action="admin.php">
      <?php if ($edit_product): ?>
        <input type="hidden" name="id" value="<?php echo $edit_product['id']; ?>"/>
      <?php endif; ?>
      <div class="form-row">
        <div class="form-group">
          <label>Product Name</label>
          <input type="text" name="name" required
            value="<?php echo $edit_product ? htmlspecialchars($edit_product['name']) : ''; ?>"/>
        </div>
        <div class="form-group">
          <label>Price (KSh)</label>
          <input type="number" name="price" step="0.01" required
            value="<?php echo $edit_product ? $edit_product['price'] : ''; ?>"/>
        </div>
      </div>
      <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="3" required><?php echo $edit_product ? htmlspecialchars($edit_product['description']) : ''; ?></textarea>
      </div>
      <div class="form-group">
        <label>Stock Quantity</label>
        <input type="number" name="stock" required
          value="<?php echo $edit_product ? $edit_product['stock'] : ''; ?>"/>
      </div>
      <?php if ($edit_product): ?>
        <button type="submit" name="update_product" class="add-btn">Update Product</button>
        <a href="admin.php" class="remove-btn" style="padding:10px 20px;">Cancel</a>
      <?php else: ?>
        <button type="submit" name="add_product" class="add-btn">Add Product</button>
      <?php endif; ?>
    </form>
  </div>

  <!-- Products Table -->
  <h3 style="margin:2rem 0 1rem;">All Products</h3>
  <table class="cart-table">
    <thead>
      <tr>
        <th>ID</th><th>Name</th><th>Price (KSh)</th><th>Description</th><th>Stock</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($products)): ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo number_format($row['price'], 2); ?></td>
        <td><?php echo htmlspecialchars($row['description']); ?></td>
        <td><?php echo $row['stock']; ?></td>
        <td>
          <a href="admin.php?edit=<?php echo $row['id']; ?>" class="admin-btn">Edit</a>
          <a href="admin.php?delete=<?php echo $row['id']; ?>"
             onclick="return confirm('Delete this product?')" class="remove-btn">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<footer>
  <p>Lucy's Tech Shop &copy; 2026 &mdash; Admin Panel &mdash; Lucy Wairimu Githire</p>
</footer>

</body>
</html>