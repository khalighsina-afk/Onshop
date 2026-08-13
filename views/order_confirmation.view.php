<!DOCTYPE html>
<html>
<header>
    <title>order_confirmation</title>
</header>
<body>
    <h1>Payment successful!</h1>
    <h2>order summery:</h2>
    <p>
        Order id = <?php echo $order_id; ?> <br>
        Order Date = <?php echo $order["order_date"]; ?> <br>
    </p>
</body>

<?php
    //Displaying items
    foreach ($items as $item):
        $product_id = $item["product_id"];
        $product= Product::find($product_id);
        
?>
    <p>
    $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$<br>

    item name= <?php echo $product["product_name"]; ?> <br>
    item price= <?php echo $product["product_price"]; ?><br>
    Subtotal price= <?php echo $item["subtotal_price"]; ?><br>
    </p>
<?php
    endforeach;
?>
    <p>Total= $<?php echo $order["total_amount"]?></p>
    <a href="products.php">Back to shopping...</a>
</html>