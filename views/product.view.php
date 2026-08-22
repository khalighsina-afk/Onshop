<?php include 'views/partials/head.view.php'; ?>

<body>
        <p>Name: <?php echo $product->name ;?></p>
        <p>Description: <?php echo $product->descr ;?></p>
        <p>Price: <?php echo  $product->price ;?></p>
        <form action="products.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>" />
            <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="1" >
            <button type="submit" name="addCart">Add to cart</button>
        </form>
</body>