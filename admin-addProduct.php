<?php
    include 'includes/myautoloader.includes.php';
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
        echo "You are not authorized to access this page.";
        echo "<a href='login.php' class='btn'>Go back</a>";
        exit;
    }

    $error = '';
    $success = '';

    if(isset($_POST['submit'])){
        $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_SPECIAL_CHARS);
        $descr = filter_var(trim($_POST['descr']), FILTER_SANITIZE_SPECIAL_CHARS);
        $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
        if (empty($name) || $price === false || $price <= 0) {
            $error = "Please fill in all fields correctly.";
        }else{
            $add= Product::insert($name, $descr, $price);
            if($add){
                header("Location: admin.php");
                exit;
            }else{
                $error = "Failed to add product.";
            }
        }
    }
    include 'views/admin-addProduct.view.php';

