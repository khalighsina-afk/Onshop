<?php
    include("database.php");
    session_start();
    $user_id = $_SESSION["user_id"];

    $sql= "SELECT products.*, cart.quantity
           FROM cart JOIN products ON cart.product_id = products.product_id
           WHERE cart.user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt , "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $total = 0;

    //remove_btn -->
    if(isset($_POST["remove_btn"])){
        $product_id = $_POST["product_id_getter"];
        $sql = "DELETE FROM cart WHERE product_id = ?;" ;
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt , "i", $product_id);
        mysqli_stmt_execute($stmt);
        header("Location: cart.php");
        exit;
    }

    //update_quantity -->
    if(isset($_POST["update_quantity"])){
        $product_id = $_POST["product_id_getter"];
        $quantity_counter =   $_POST["quantity_counter"];
        $sql="UPDATE cart SET quantity= ? WHERE product_id= ? AND user_id =?";
        $stmt= mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $quantity_counter, $product_id, $user_id);
        mysqli_stmt_execute($stmt);
        header("Location: cart.php");
        exit;
    }

    while($row = mysqli_fetch_assoc($result)){
    $subtotal = $row["product_price"] * $row["quantity"];
    $total +=   $subtotal;
     ?>
    <p>
        *******************************************<br>
        Product ID= <?php echo $row["product_id"]; ?>     <br>
        Product name= <?php echo $row["product_name"]; ?> <br>
        Product price= $<?php echo $row["product_price"]; ?> <br>
        Subtotal= $<?php echo number_format($subtotal, 2); ?> <br>
    </p>
    <form action="cart.php" method="post" >
        <input type="hidden" name="product_id_getter" value="<?php echo $row["product_id"]; ?>">
        Quantity= <input type="number" name="quantity_counter" value="<?php echo $row["quantity"]; ?>" min="1">
        <button type="input" name="update_quantity" >Apply</button>
        <button type="input" name="remove_btn" >Remove</button>
    </form>


<?php
    }

    echo "Total = \${$total} ";

    mysqli_close($conn);
?>