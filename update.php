<?php
    include 'includes/myautoloader.includes.php';
    session_start();
    if (!isset($_SESSION['user_uid']) || $_SESSION['user_uid'] != 'admin') {
        header("Location: login.php");
        exit;
    }


    if(isset($_POST['submit'])){
        $id = filter_var($_POST["id"], FILTER_VALIDATE_INT);
        $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_SPECIAL_CHARS);
        $price = filter_var($_POST["price"], FILTER_VALIDATE_FLOAT);
        $descr = filter_var(trim($_POST["descr"]), FILTER_SANITIZE_SPECIAL_CHARS);
        if ($id === false || $id <= 0 || empty($name) || $price === false || $price <= 0) {
            echo "Invalid input.";
            exit;
        }

        $update = Product::update($id, $name, $descr, $price);
        if($update){
            header ("Location: admin.php");
            exit;
        }else{
            echo "something went wrong";
        }

    }
    if(!isset($_GET['get_id'])){
        header("location: admin.php");
        exit;
    }
    $id = filter_var($_GET["get_id"], FILTER_VALIDATE_INT);
    if ($id === false || $id <= 0) {
        header("Location: admin.php");
        exit;
    }
    $find = Product::find($id);
    if(!$find){
        header("location: admin.php");
        exit;
    }
    $name = $find['product_name'];
    $price = $find['product_price'];
    $descr = $find['product_descr'];
    include 'views/update-form.view.php';