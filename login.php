
<?php
    include 'includes/myautoloader.includes.php';
    session_start();
    $error = '';

    if(isset($_POST["login"])){
        $username=$_POST["user_name"];
        $password=$_POST["password"];

        //check if empty
        if(empty($_POST["user_name"]) || empty($_POST["password"])){
            echo "Please enter your username or password";
            include 'views/login-form.view.php';
            exit;
        }


        $result = User::login($username, $password);
        if ($result == 'locked'){
            $error = 'your account is locked. please try again in 5 minutes.';
            include 'views/login-form.view.php';
            exit ;
        }elseif($result === false) {
            $error= "invalid username or password";
            include 'views/login-form.view.php';
            exit;
        }else{
            $_SESSION["user_id"] = $result["user_id"];
            $_SESSION["username"] = $result["username"];
            $_SESSION["role"] = $result["user_uid"];
            if($result["user_id"]== "admin"){
                header ("Location: admin.php");
            }else {
                header("Location: test.php");
                exit;
            }
        }
    }
    include 'views/login-form.view.php';
