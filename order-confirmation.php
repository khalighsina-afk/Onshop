<?php
    include ("includes/myautoloader.includes.php");
    session_start();
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit;
    }
    $user_id = $_SESSION["user_id"];
    if (!isset($_GET["order_id"])) {
        header("Location: products.php");
        exit;
    }
    $order_id = filter_var($_GET["order_id"], FILTER_VALIDATE_INT);
    if ($order_id === false || $order_id <= 0) {
        header("Location: products.php");
        exit;
    }

    $order = Order::find($order_id);
    if (!$order) {
        header("Location: products.php");
        exit;
    }
    if ($order['user_id'] != $user_id) {
        header("Location: products.php");
        exit;
    }
    $items = Order::getItems($order_id);
    
    include 'views/order-confirmation.view.php';