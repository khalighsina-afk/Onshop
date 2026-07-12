<?php
    include("database.php");
    session_start();

    if(!isset($_SESSION["user_id"])){
        header ("Location: login.php");
        exit;
    }
    $user_id=$_SESSION["user_id"];

    //Selecting the cart contents
    $cart_sql = "SELECT products.*, cart.quantity FROM cart
                 JOIN products ON cart.product_id = products.product_id
                 WHERE user_id = ?;";
    $cart_stmt= mysqli_prepare($conn, $cart_sql);
    mysqli_stmt_bind_param($cart_stmt, "i", $user_id);
    mysqli_stmt_execute($cart_stmt);
    $cart_result= mysqli_stmt_get_result($cart_stmt);

    //Calculating total price
    $total_sql ="SELECT SUM(products.product_price * cart.quantity ) AS cart_total
                 FROM  cart JOIN products ON cart.product_id = products.product_id
                 WHERE user_id = ?";
    $total_stmt= mysqli_prepare($conn, $total_sql);
    mysqli_stmt_bind_param($total_stmt, "i", $user_id);
    mysqli_stmt_execute($total_stmt);
    $total_result = mysqli_stmt_get_result($total_stmt);
    $total_row = mysqli_fetch_assoc($total_result);
    $cart_total = $total_row["cart_total"];

    //Placing order
    if(isset($_POST["place_order_btn"])){

        if(mysqli_num_rows($cart_result) <= 0){
            echo "empty cart!";
        }else{
            //insert into orders table
            $order_sql = "INSERT INTO orders(user_id, total_amount)
                          VALUES (?, ?)";
            $order_stmt = mysqli_prepare($conn, $order_sql);
            mysqli_stmt_bind_param($order_stmt, "id", $user_id, $cart_total);
            mysqli_stmt_execute($order_stmt);
            $order_id = mysqli_insert_id($conn);


            //Adding to Order_items table
            mysqli_data_seek($cart_result, 0);
            while($row = mysqli_fetch_assoc($cart_result)){
                $product_id = $row["product_id"];
                $quantity = $row["quantity"];
                $price = $row["product_price"];
                $subtotal = $price * $quantity ;
                $items_sql = "INSERT INTO order_items(order_id, product_id, items_quantity,
                                          price, subtotal_price)
                                      VALUES (?, ?, ? ,? ,?) ";
                $items_stmt = mysqli_prepare($conn, $items_sql);
                mysqli_stmt_bind_param($items_stmt, "iiidd", $order_id, $product_id, $quantity,
                                       $price , $subtotal);
                mysqli_stmt_execute($items_stmt);

            }

            //Clear cart
            $clear_cart_sql="DELETE FROM cart WHERE user_id=?";
            $clear_cart_stmt= mysqli_prepare($conn, $clear_cart_sql);
            mysqli_stmt_bind_param($clear_cart_stmt, "i",$user_id);
            mysqli_stmt_execute($clear_cart_stmt);

            header ("Location: order_confirmation.php?order_id=". $order_id);
            exit;
        }
    }
?>
<!DOCTYPE html>
<html>
<header>
    <title>Checkout</title>
</header>
<body>
    <a href="cart.php">Back to cart...</a>
    <h1>Order Summary</h1>
<?php
    if(mysqli_num_rows($cart_result) <= 0): ?>
            <p>there is no item in the cart</p>
            <a href="products.php">Let's go add some products!</a>
<?php
    else:
?>
<?php
        mysqli_data_seek($cart_result, 0);
        while($cart_row= mysqli_fetch_assoc($cart_result)):
            $subtotal = $cart_row["product_price"] * $cart_row["quantity"];
?>
            <p>
                $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$<br>
                Product name= <?php echo $cart_row["product_name"]?><br>
                Product price= <?php echo $cart_row["product_price"]?><br>
                Quantity= <?php echo $cart_row["quantity"]?><br>
                Subtotal= <?php echo "\${$subtotal}"; ?><br>
            </p>
<?php
        endwhile;
?>
        <h2>Total = $<?php echo number_format($cart_total, 2);?></h2>
        <form action="checkout.php" method="post">
            <button type="submit" name="place_order_btn">Place Order!</button>
        </form>
<?php
    endif;
?>
</body>
</html>
<?php
    mysqli_close($conn);
?>