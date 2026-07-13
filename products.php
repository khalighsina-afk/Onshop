<?php
    include ("database.php");
    session_start();
    $user_id = $_SESSION["user_id"];
    ?>
    <html><a href="cart.php">view cart...</a> </html>
    <html><a href="user_panel.php">user panel...</a> </html>
<?php
    if(isset($_POST["add_cart_btn"])){
        $quantity = $_POST["quantity_counter"];
        $product_id = $_POST["product_id_getter"];
        $check_sql= "SELECT * FROM cart WHERE user_id= ? AND product_id = ?";
        $check_stmt= mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt , "ii", $user_id, $product_id);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);
        if(mysqli_num_rows($check_result) > 0){
            $add_sql = "UPDATE cart SET quantity= quantity + ? WHERE user_id = ? AND product_id = ?;" ;
            $add_stmt= mysqli_prepare($conn, $add_sql);
            mysqli_stmt_bind_param($add_stmt, "iii", $quantity, $user_id, $product_id);
            mysqli_stmt_execute($add_stmt);
        }else{
            $sql = "INSERT INTO cart(user_id, product_id, quantity) VALUES (?, ?, ?);" ;
            $stmt = mysqli_prepare($conn , $sql);
            mysqli_stmt_bind_param($stmt, "iii", $user_id, $product_id, $quantity);
            mysqli_stmt_execute($stmt);
        }
        header("Location: products.php");
        exit;
    }

        $cart_sql = "SELECT  product_id, quantity FROM cart WHERE user_id = ?;" ;
        $cart_stmt = mysqli_prepare($conn, $cart_sql);
        mysqli_stmt_bind_param($cart_stmt, "i", $user_id);
        mysqli_stmt_execute($cart_stmt);
        $cart_result = mysqli_stmt_get_result($cart_stmt);
        $cart_items= [];
        while ($cart_row = mysqli_fetch_assoc($cart_result)){
            $cart_items[$cart_row["product_id"]]= $cart_row["quantity"];
        }

        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);

    while($row= mysqli_fetch_assoc($result)){
        $product_id = $row["product_id"];
        $in_cart = isset($cart_items[$product_id]);
        $qty = $in_cart ? $cart_items[$product_id] : 1;
    ?>
        <p>
            =============================================<br>
            Product name= <?php echo $row["product_name"]; ?> <br>
            Product description= <?php echo $row["product_descr"] ?><br>
            price= $<?php echo $row["product_price"]?><br>

            <?php if($in_cart):?>
                <span style="color: green;">✅in cart</span><br>
            <?php endif; ?>
        </p>
        <form action="products.php" method="post">
            <input  type=hidden    name="product_id_getter" value="<?php echo $row["product_id"]; ?>" >
            <input type="number"  name="quantity_counter" min="1" value="<?php echo $qty; ?>" >
            <button type="submit"  name="add_cart_btn">
                <?php echo $in_cart ? "Update cart" : "Add to cart"; ?>
            </button>

        </form>
<?php
    }


    mysqli_close($conn);
?>
