<?php
    include "includes/myautoloader.includes.php";
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header ("Location: login.php");
        exit;
    }
    $error = '';
    $id = $_SESSION['user_id'];
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        if(empty($username) || empty($password) || empty($confirm_password)){
            $error = "Please complete the form!";
            exit;
        }
        elseif($password != $confirm_password){
            $error = "Passwords do not match";
            exit;
        }else{
            User::change($id, $username, $password);
            echo "Success!";
        }
    }
    include "views/change_user.view.php";