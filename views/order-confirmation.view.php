<?php include 'views/partials/head.view.php'; ?>
<?php include 'views/partials/header.view.php'; ?>
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
    <div class="divider"></div>
    <p>item name= <?php echo $product["product_name"]; ?></p> <br>
    <p>item price= <?php echo $product["product_price"]; ?></p><br>
    <p>Subtotal price= <?php echo $item["subtotal_price"]; ?></p><br>
    </p>
<?php
    endforeach;
?>
    <p>Total= $<?php echo $order["total_amount"]?></p>
    <a href="products.php" class="nav-link">Back to shopping...</a>
</html>