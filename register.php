<?php
    include 'includes/myautoloader.includes.php';
    session_start();
    $error ='';
    if(isset($_POST["register"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $password_repeat = $_POST["password_repeat"];
        $email = $_POST["email"];
        if (empty($username) || empty($password) || empty($email)) {
            echo "Please complete the form.";
            include 'views/register-form.view.php';
            exit;
        } elseif ($password !== $password_repeat) {
            echo "password do not match.";
            include 'views/register-form.view.php';
            exit;
        } elseif (strlen($password) < 8) {
            echo "Password must be longer than 8 characters";
            include 'views/register-form.view.php';
            exit;
        }
        if($password !== $password_repeat) {
            echo "password do not match.";
            include 'views/register-form.view.php';
        }else{
            $reg= User::register($username, $email, $password);
            $user= User::find($reg);
            $_SESSION["username"] = $username;
            $_SESSION["user_id"] = $reg;
            header ("Location: test.php");
            exit;
        }
    }
    include 'views/register-form.view.php';
?>

