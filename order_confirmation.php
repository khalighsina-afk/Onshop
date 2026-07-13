<?php
    include ("database.php");
    session_start();
    $user_id = $_SESSION["user_id"];
    $order_id = $_GET["order_id"];

    //Fetching order date and id and total amount
    $order_sql = "SELECT order_id, order_date, total_amount
                  FROM orders
                  WHERE order_id = ? AND user_id = ?;" ;
    $order_stmt = mysqli_prepare($conn, $order_sql);
    mysqli_stmt_bind_param($order_stmt, "ii", $order_id, $user_id);
    mysqli_stmt_execute($order_stmt);
    $order_result = mysqli_stmt_get_result($order_stmt);
    $order_row = mysqli_fetch_assoc($order_result);

    //Order items
    $item_sql = "SELECT product_name, items_quantity, product_price, subtotal_price
                 FROM order_items
                 JOIN products ON order_items.product_id = products.product_id
                 WHERE order_id=?;";
    $items_stm = mysqli_prepare($conn, $item_sql);
    mysqli_stmt_bind_param($items_stm, "i", $order_id);
    mysqli_stmt_execute($items_stm);
    $items_result= mysqli_stmt_get_result($items_stm);
?>
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
        Order Date = <?php echo $order_row["order_date"]; ?> <br>
    </p>
</body>

<?php
    //Displaying items
    while ($row= mysqli_fetch_assoc($items_result)):
?>
    <p>
    $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$<br>

    item name= <?php echo "{$row["items_quantity"]} * {$row["product_name"]}"; ?> <br>
    item price= <?php echo $row["product_price"]; ?><br>
    Subtotal price= <?php echo $row["subtotal_price"]; ?><br>
    </p>
<?php
    endwhile;
?>
    <p>Total= $<?php echo $order_row["total_amount"]?></p>
    <a href="products.php">Back to shopping...</a>
</html>
<?php
    mysqli_close($conn);
?>