<?php include 'views/partials/head.view.php';
      include 'views/partials/header.view.php';
if(!empty($error)):?>
    <p class="error_message"><?php echo htmlspecialchars($error);?></p>
<?php endif;?>
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
<a href="admin.php" class="btn">Back to All products-></a><br>