<html>
<body>
    <?php if($error):?>
        <p style="color: red;"><?php echo $error; ?> </p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <div id=login>
            <label>Username:</label>            <br>
            <input  type="text" name="user_name"> <br>
            <label>Password:</label>            <br>
            <input  type="password" name="password"> <br>
            <button type= "submit" name="login">Login</button><br>
            <a>Don't have an account? Register here...</a>
        </div>

    </form>


</body>
</html>