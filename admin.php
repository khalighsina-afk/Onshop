<?php
    include 'includes/myautoloader.includes.php';
    session_start();
    if(!isset($_SESSION['user_uid']) || $_SESSION['user_uid'] != 'admin'){
        echo "You are not authorized to access this page.";
        echo "<a href='login.php'>Go back</a>";
        exit;
    }
    if(isset($_POST['delete'])){
        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            header("Location: admin.php");
            exit;
        }
        $delete= Product::delete($id);
        if($delete){
            header("Location: admin.php");
            exit;
        }else{
            echo "Error deleting product";
        }
    }



    //updates:
    if(isset($_GET["get_id"])){
        $id = filter_var($_GET["get_id"], FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            header("Location: admin.php");
            exit;
        }
        header("Location: update.php?get_id=$id");
        exit;
    }
    $products = Product::getAll();
    include "views/admin-product-form.view.php";

