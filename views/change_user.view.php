<?php include 'views/partials/head.view.php';
if(!empty($error)):?>
    <p class="error_message"><?php echo htmlspecialchars($error);?></p>
<?php endif;?>
    <div>
        <label>Enter new username:</label><br>
        <input type="text" name="username"><br>
        <label>Enter new password:</label><br>
        <input type="text" name="password"><br>
        <label>confirm password:</label><br>
        <input type="text" name="confirm_password"><br>
        <button type="submit" name="submit">Save</button>
    </div>
</body>
</html>
