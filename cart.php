<?php
    include 'includes/myautoloader.includes.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    $total = 0 ;

    if (isset($_POST["update"])) {
        $quantity = $_POST["quantity"];
        $product_id = $_POST["product_id"];
        Cart::quantity($quantity, $product_id, $user_id);
        header ("Location: cart.php");
        exit;
    }

    if (isset($_POST["delete"])){
        $product_id = $_POST["product_id"];
        Cart::delete($user_id, $product_id);
        header ("Location: cart.php");
        exit;
    }

    $items = Cart::showAllItems($user_id);
    include 'views/cart.view.php';


