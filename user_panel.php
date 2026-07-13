<?php
    include ("database.php");
    session_start();
    if(!isset($_SESSION["user_id"])){
        header ("Location: login.php");
        exit;
    }else{
        $user_id=$_SESSION["user_id"];
    }
    if(isset($_POST["logout_btn"])){
        session_destroy();
        header("Location: login.php");
        exit;
    }

    //displaying username
    $name_sql = "SELECT user_name
                 FROM users
                 WHERE user_id = ?";
    $name_stmt = mysqli_prepare($conn, $name_sql);
    mysqli_stmt_bind_param($name_stmt, "i", $user_id);
    mysqli_stmt_execute($name_stmt);
    $name_result= mysqli_stmt_get_result($name_stmt);
    $name_row=mysqli_fetch_assoc($name_result);
    mysqli_stmt_close($name_stmt);

    //Displaying order history
    $sql = "SELECT order_id, order_date, total_amount, order_status
            FROM orders
            WHERE user_id= ? ";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result= mysqli_stmt_get_result($stmt);

?>
<!DOCTYPE html>
<html>
<header>
    <title>user_panel</title>
</header>
<body>
    <h1>User's panel</h1>
    <p>Welcome <?php echo htmlspecialchars($name_row["user_name"]); ?>!</p>
    <form action="user_panel.php" method="post"><button type="submit" name="logout_btn">logout</button></form>
    <h2>Orders history</h2>
<?php
    while($row=mysqli_fetch_assoc($result)):
?>
    <p>
        ---------------------------------------------------------------------------------------------<br>
        <a href="order_confirmation.php?order_id=<?php echo $row["order_id"]?>">
        submit date: <?php echo $row["order_date"];?> total amount: $<?php echo $row["total_amount"];?>
         order status: <?php echo $row["order_status"];?></a>

    </p>
<?php
    endwhile;
?>
</body>
</html>
