<html>
<body>
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
            <a href="login.php">Already have an account? Log-in here...</a>
        </div>

    </form>


</body>
</html>
<?php
    include("database.php");
    if(isset($_POST["register"])){
        $username=$_POST["username"];
        $password=$_POST["password"];
        $password_repeat= $_POST["password_repeat"];
        $email = $_POST["email"];
        if(empty($username) || empty($password) || empty($email)){
            echo "Please complete the form.";
        }elseif($password !== $password_repeat){
            echo "password do not match.";
        }elseif(strlen($password) < 8 ){
            echo "Password must be longer than 8 characters";
        }else{
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users(user_name, user_password, email) VALUES (?, ?, ?);";
            $stmt= mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $username, $hash, $email);
            mysqli_stmt_execute($stmt);
            header ("Location: login.php");
            exit;
        }
    }
    mysqli_close($conn);
?>

