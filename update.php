<?php
    include 'includes/myautoloader.includes.php';
    session_start();



    if(isset($_POST['submit'])){
        $id = $_POST["id"];
        $name = $_POST["name"];
        $price = $_POST["price"];
        $descr = $_POST["descr"];
        $update = Product::update($id, $name, $descr, $price);
        if($update){
            echo "product updated successfully";
            header ("Location: admin.php");
        }else{
            echo "something went wrong";
        }

    }
    if(!isset($_GET['get_id'])){
        header("location: admin.php");
        exit;
    }
    $id = $_GET["get_id"];
    $find = Product::find($id);
    if(!$find){
        header("location: admin.php");
        exit;
    }
    $name = $find['product_name'];
    $price = $find['product_price'];
    $descr = $find['product_descr'];
    include 'views/update-form.view.php';