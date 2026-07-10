
<html>
<body>
    <form action="login.php" method="post">
        <div id=login>
            <label>Username:</label>            <br>
            <input  type="text" name="username"> <br>
            <label>Password:</label>            <br>
            <input  type="password" name="password"> <br>
            <button type= "submit" name="login">Login</button><br>
            <a href="register.php">Don't have an account? Register here...</a>
        </div>

    </form>


</body>
</html>
<?php
    include("database.php");
    session_start();
    if(isset($_POST["login"])){
        $username= $_POST["username"];
        $password= $_POST["password"];
        if(empty($username) || empty($password)){
            echo "Please enter your username or password";
        }else{
            $sql = "SELECT * FROM users WHERE user_name=?";
            $stmt= mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            if($row){
                if(password_verify($password, $row["user_password"])){
                    $_SESSION["user_id"]= $row["user_id"];
                    $_SESSION["user_name"]= $row["user_name"];
                    $_SESSION["role"]=$row["user_uid"];

                    if($row["user_uid"]== "admin"){
                        header("Location: admin.php");
                    }else{
                        header("Location: index.php");
                    }
                    exit;
                }else{
                    echo "invalid password";
                }
            }else{
                echo "username not found";
            }
        }
    }
    mysqli_close($conn);
?>