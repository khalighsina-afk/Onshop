<?php
    include 'includes/myautoloader.includes.php';
    session_start();
    if (isset($_SESSION['user_id'])) {
        header("Location: products.php");
        exit;
    }
    $error ='';

    if(isset($_POST["register"])) {
        $username = filter_var(trim($_POST["username"]), FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST["password"];
        $password_repeat = $_POST["password_repeat"];
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        //validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
            include 'views/register-form.view.php';
            exit;
        }
        //Check empty
        if (empty($username) || empty($password) || empty($email)) {
            echo "Please complete the form.";
            include 'views/register-form.view.php';
            exit;

        }
        //Check password match
        if ($password !== $password_repeat) {
            echo "password do not match.";
            include 'views/register-form.view.php';
            exit;
        }
        //Check password length
        if (strlen($password) < 8) {
            echo "Password must be longer than 8 characters";
            include 'views/register-form.view.php';
            exit;
        }
        $reg= User::register($username, $email, $password);
        $_SESSION["username"] = $username;
        $_SESSION["user_id"] = $reg;
        header ("Location: products.php");
        exit;
    }
    include 'views/register-form.view.php';
?>

