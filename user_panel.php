<?php
    include ("includes/myautoloader.includes.php");
    session_start();
    if(!isset($_SESSION["user_id"])){
        header ("Location: login.php");
        exit;
    }else{
        $user_id=$_SESSION["user_id"];
        $user= User::find($user_id);

        $orders = Order::getAll($user_id);

    }
    if(isset($_POST["logout_btn"])){
        session_destroy();
        header("Location: login.php");
        exit;
    }

include 'views/user_panel.view.php';
