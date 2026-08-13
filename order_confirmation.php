<?php
    include ("includes/myautoloader.includes.php");
    session_start();
    $user_id = $_SESSION["user_id"];
    $order_id = $_GET["order_id"];

    $order = Order::find($order_id);
    $items = Order::getItems($order_id);
    
    include 'views/order_confirmation.view.php';

