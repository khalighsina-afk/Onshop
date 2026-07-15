
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
            exit;
        }
        $sql = "SELECT * FROM users WHERE user_name=?";
        $stmt= mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if($row){
            if($row["locked_until"] && strtotime($row["locked_until"]) > time() ){
                echo "Your account is locked.if try again in 15 minutes";
                exit;
            }
            if(password_verify($password, $row["user_password"])){
                $reset_sql="UPDATE users SET failed_attempts =0, locked_until= NULL WHERE user_id= ?; ";
                $reset_stmt= mysqli_prepare($conn, $reset_sql);
                mysqli_stmt_bind_param($reset_stmt, "i", $row["user_id"]);
                mysqli_stmt_execute($reset_stmt);

                $_SESSION["user_id"]= $row["user_id"];
                $_SESSION["user_name"]= $row["user_name"];
                $_SESSION["role"]=$row["user_uid"];

                if($row["user_uid"]== "admin"){
                    header("Location: admin.php");
                }else{
                    header("Location: products.php");
                }
                exit;
            }else{
                $failed_attempts = $row["failed_attempts"] + 1;
                $update_sql = "UPDATE users SET failed_attempts = ? WHERE user_id=? ";
                $update_stmt = mysqli_prepare($conn, $update_sql);
                mysqli_stmt_bind_param($update_stmt, "ii", $failed_attempts, $row["user_id"]);
                mysqli_stmt_execute($update_stmt);

                //Limiting failed attempts
                if($failed_attempts >= 5){
                    $locked_until = date('Y-m-d H:i:s', strtotime('+15 minutes'));
                    $locked_sql = "UPDATE users SET locked_until = ?  WHERE user_id = ?";
                    $locked_stmt = mysqli_prepare($conn, $locked_sql);
                    mysqli_stmt_bind_param($locked_stmt, "si", $locked_until, $row["user_id"] );
                    mysqli_stmt_execute($locked_stmt);
                    echo "Too many failed attempts. Account locked for 15 minutes.";
                }else{
                    echo "Wrong password. {$failed_attempts} of 5 attempts.";
                }
            }
        }else{
            echo "username not found";
        }

    }
    mysqli_close($conn);
?>