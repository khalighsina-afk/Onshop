<?php include 'views/partials/head.view.php'; ?>
<?php include 'views/partials/header.view.php'; ?>
<body>
<?php if(!empty($error)):?>
    <p class="error_message"><?php echo htmlspecialchars($error);?></p>
<?php endif;?>
    <form action="login.php" method="post">
        <div id=login>
            <label>Username:</label>            <br>
            <input  type="text" name="user_name"> <br>
            <label>Password:</label>            <br>
            <input  type="password" name="password"> <br>
            <button type= "submit" name="login">Login</button><br>
            Don't have an account? Register<a href="register.php"> here...</a>
        </div>

    </form>


</body>
