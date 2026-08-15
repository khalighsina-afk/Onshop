<?php
    include 'includes/myautoloader.includes.php';
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    $user_id = $_SESSION['user_id'];
    $total = 0 ;

    if (isset($_POST["update"])) {
        $quantity = filter_var($_POST["quantity"], FILTER_VALIDATE_INT);
        $product_id = filter_var($_POST["product_id"], FILTER_VALIDATE_INT);

        if ($quantity === false || $quantity < 1 || $product_id === false) {
            header("Location: cart.php");
            exit;
        }
        Cart::quantity($quantity, $product_id, $user_id);
        header ("Location: cart.php");
        exit;
    }

    if (isset($_POST["delete"])){
        $product_id = filter_var($_POST["product_id"], FILTER_VALIDATE_INT);
        if ($product_id === false) {
            header("Location: cart.php");
            exit;
        }

        Cart::delete($user_id, $product_id);
        header ("Location: cart.php");
        exit;
    }

    $items = Cart::showAllItems($user_id);
    include 'views/cart.view.php';


