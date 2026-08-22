<?php include 'views/partials/head.view.php';
foreach ($cartItems as $item):
        $subtotal = $item->product_price * $item->quantity;
?>
        <p>
            <div class="divider"></div>
            Product name= <?php echo $item->product_name?><br>
            Product price= <?php echo $item->product_price?><br>
            Quantity= <?php echo $item->quantity?><br>
            Subtotal= <?php echo "\${$subtotal}"; ?><br>
        </p>
<?php endforeach; ?>

<p>Total amount: <?php echo "$" . $total;?></p>
    <form action="checkout.php" method="post">
<button type="submit" name="place_order">Place Order!</button>
    </form>