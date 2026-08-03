<?php
    include 'includes/myautoloader.includes.php';
    session_start();

    $user_id = $_SESSION['user_id'] ?? NULL;
    $cartMap = [];
    if($user_id){
        echo $user_id;

        //show all products in a list
        $products= Product::getAll();
        $cartItems = Cart::showAllItems($user_id);
        foreach ($cartItems as $Item) {
            $cartMap[$Item->product_id] = $Item->quantity;
        }
    }else{
        include 'views/login-button.view.php';
    }

    foreach($products as $product){
        if(isset($cartMap[$product->id]) ?? 1){
            $quantity = $cartMap[$product->id];
        }

        $product_id = $product->id;
        echo "name: " . $product->name . "<br>";
        echo "description: " . $product->descr . "<br>";
        echo "$" . $product->price . "<br>";
        include 'views/product.view.php';
    }

    if(isset($_POST["addCart"])){
        if(!$user_id){
            header ("Location: login.php");
            exit;
        }
            $product_id = $_POST["product_id"];
            $quantity = $_POST["quantity"];

            $result = Cart::insert($user_id, $product_id, $quantity);

            if($result){
                header("Location: products.php");
                exit;
            }else{
                echo "failed to insert to the cart";
            }
    }