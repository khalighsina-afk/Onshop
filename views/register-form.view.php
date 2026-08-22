<?php include 'views/partials/head.view.php'; ?>
<?php include 'views/partials/header.view.php'; ?>
<body>
<?php if(!empty($error)):?>
    <p class="error_message"><?php echo htmlspecialchars($error);?></p>
<?php endif;?>
    <form action="register.php" method="post">
        <div id=login>
            <label>Username:</label>            <br>
            <input  type="text" name="username"> <br>
            <label>Password:</label>            <br>
            <input  type="password" name="password"> <br>
            <label>Repeat password:</label>            <br>
            <input  type="password" name="password_repeat"> <br>
            <label>email:</label>            <br>
            <input  type="email" name="email"> <br>
            <button type= "submit" name="register">Register</button><br>
            Already have an account? Log-in<a href="login.php"> here...</a>
        </div>

    </form>


</body>