<?php
    include 'includes/myautoloader.includes.php';
    session_start();

    $user_id = $_SESSION['user_id'] ?? NULL;
    $cartMap = [];
    if($user_id){
        //show all products in a list
        $cartItems = Cart::showAllItems($user_id);
        foreach ($cartItems as $Item) {
            $cartMap[$Item->product_id] = $Item->quantity;
        }
    }else{
        include 'views/login-button.view.php';
    }
    $products= Product::getAll();

    
    if(isset($_POST["addCart"])){
        if(!$user_id){
            header ("Location: login.php");
            exit;
        }
        $product_id = filter_var($_POST["product_id"], FILTER_VALIDATE_INT);
        $quantity = filter_var($_POST["quantity"][$product_id], FILTER_VALIDATE_INT);
        if ($product_id === false || $quantity === false || $quantity < 1) {
            echo "Invalid input.";
            exit;
        }
        $result = Cart::insert($user_id, $product_id, $quantity);

        if($result){
            header("Location: products.php");
            exit;
        }else{
            echo "failed to insert to the cart";
        }
    }

    foreach ($products as $product) {
        $quantity = $cartMap[$product->id] ?? 1;
        include 'views/product.view.php';
    }
    