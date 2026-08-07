<!DOCTYPE html>
<html lang="en">
    <title>ADMIN PANEL</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <a href="admin-addProduct.php">Add a product-></a>
<?php foreach($products as $product): ?>
    <div>
        <p>Name: <?php echo $product->name;?></p>
        <p>Description: <?php echo $product->descr;?></p>
        <p>Price: $<?php echo $product->price;?></p>

    <form action="admin.php" method="post">
        <input type="hidden" name="id" value="<?php echo $product->id; ?>">
        <button type="submit" name="delete">delete</button>
    </form>
    <form action="admin.php" method="get">
        <input type="hidden" name="get_id" value="<?php echo $product->id; ?>">
        <button type="submit" name="update">update</button>
        <p>***********************************************</p>
    </form>
    </div>
<?php endforeach; ?>
</html>