<!DOCTYPE html>
<html lang="en">
<title>cart</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

    <div>

        <?php foreach ($items as $item): ?>
            <form   action="cart.php"   method="post">
                <p>name: <?php echo  $item->product_name;?></p>
                <p>price: <?php echo "$". $item->product_price;?></p>
                <p>subtotal: <?php echo "$". $subtotal= $item->product_price * $item->quantity; ?></p>
                <?php $total += $subtotal ;?>
                <input type="hidden" name="product_id" value="<?php echo $item->product_id;?>" min="1">
                <input type="number" name="quantity" value="<?php echo $item->quantity; ?>" min="1">
                <button type="submit" name="update">Update</button>
                <button type="submit" name="delete">Delete</button>
            </form>
                <p>=======================</p>
        <?php endforeach; ?>
        <p>Total: <?php echo $total;?> </p>
        <a href="checkout.php">
            <button>proceed to checkout</button>
        </a>
    </div>

</html>