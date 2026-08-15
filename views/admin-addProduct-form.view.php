<!DOCTYPE html>
<html lang="en">
<title>ADMIN ADD PRODUCT</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>
<form action="admin-addProduct.php" method="post">
    <label>Enter product's title:</label><br>
    <input type="text" name="name"><br>
    <label>Enter product's description: </label><br>
    <input type="text" name="descr"><br>
    <label>Enter product's price: </label><br>
    <input type="text" name="price"><br>
    <button type="submit" name="submit">Save</button>
</form>
<a href="admin.php">Back to All products-></a><br>