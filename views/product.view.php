<html>
<body>

    <form action="products.php" method="post">
        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>" />
        <input type="number" name="quantity[<?php echo $product->id; ?>]" value="<?php echo $quantity; ?>" min="1" >
        <button type="submit" name="addCart">Add to cart</button>
    </form>
</body>
</html>