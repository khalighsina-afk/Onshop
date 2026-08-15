<!DOCTYPE html>
<html>
<header>
    <title>user_panel</title>
</header>
<body>
    <h1>User's panel</h1>
    <?php if ($user): ?>
        <h1>Welcome, <?php echo htmlspecialchars($user['user_name']); ?></h1>
        <form action="user_panel.php" method="post"><button type="submit" name="logout_btn">logout</button></form>
    <?php endif; ?>
    <?php if (empty($orders)): ?>
        <p>You haven't placed any orders yet.</p>
    <?php else: ?>
    <h2>Orders history</h2>
<?php
    foreach($orders as $order):
?>
    <p>
        ---------------------------------------------------------------------------------------------<br>
        <a href="order_confirmation.php?order_id=<?php echo $order["order_id"]?>">
        submit date: <?php echo $order["order_date"];?> total amount: $<?php echo $order["total_amount"];?>
         order status: <?php echo $order["order_status"];?></a>

    </p>
<?php
    endforeach;
    endif;
?>
</body>
</html>