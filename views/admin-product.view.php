<?php include 'views/partials/head.view.php'; ?>
<?php include_once 'views/partials/header.view.php'; ?>
<a href="admin-addProduct.php" class="btn">Add a Product:</a>
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
        <div class="divider"></div>
    </form>
    </div>
<?php endforeach; ?>
</html>