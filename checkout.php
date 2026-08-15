<?php
    include("includes/myautoloader.includes.php");
    session_start();

    if(!isset($_SESSION["user_id"])){
        header ("Location: login.php");
        exit;
    }
    $user_id=$_SESSION["user_id"];

    $cartItems = Cart::showAllItems($user_id);



    if (empty($cartItems)) {
        echo "Your cart is empty.";
        echo "<a href='products.php'>Browse Products</a>";
        exit;
    }
    $total= Cart::total($user_id);

    if(isset($_POST['place_order'])){
        $pdo= Database::getConnection();

        try {
            $pdo->beginTransaction();
            //placing order in the orders table
            $order_id = Order::insert($user_id, $total);
            foreach ($cartItems as $item) {
                $subtotal = $item->product_price * $item->quantity;
                Order::itemsInsert(
                    $order_id,
                    $item->product_id,
                    $item->quantity,
                    $item->product_price,
                    $subtotal);

                echo "Done";

            }
            Cart::clear($user_id);
            $pdo->commit();
            header("Location: order_confirmation.php?order_id=" . $order_id);
            exit;
        }catch(Exception $e){
            $pdo->rollBack();
            echo "Order failed: " . $e->getMessage();
            exit;
        }
    }
    include 'views/checkout.view.php';
?>