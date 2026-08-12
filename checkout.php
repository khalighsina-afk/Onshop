<?php
    include("includes/myautoloader.includes.php");
    session_start();

    if(!isset($_SESSION["user_id"])){
        header ("Location: login.php");
        exit;
    }
    $user_id=$_SESSION["user_id"];

    $cartItems = Cart::showAllItems($user_id);
    $total = 0;
    $total= Cart::total($user_id);

    if(isset($_POST['place_order'])){
        if(!$cartItems){
            echo "no item in the cart!";
            exit;
        }else{

            //placing order in the orders table
            $order_id = Order::insert($user_id ,$total);
            //adding the cart items into order_items table
            foreach ($cartItems as $item) {
                $subtotal = $item->product_price * $item->quantity;
                Order::itemsInsert(
                        $order_id,
                        $item->product_id,
                        $item->quantity,
                        $item->product_price,
                        $subtotal);
                Cart::clear($user_id);
                echo "Done";
                header("Location: checkout.php");
            }


        }


    }
    include 'views/checkout.view.php';
?>