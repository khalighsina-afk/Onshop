<?php
    include 'includes/myautoloader.includes.php';
    session_start();
    if(isset($_POST['delete'])){
        $id = $_POST['id'];
        $delete= Product::delete($id);
        if($delete){
            echo "Product deleted successfully";
            header("Location: admin.php");
            exit;
        }else{
            echo "Error deleting product";
        }
    }
//    if($_SESSION['user_uid'] != 'admin'){
//        echo "You are not authorized to access this page.";
//        echo "<a href='login.php'>Go back</a>";
//        exit;
//    }
    $products = Product::getAll();

        //updates:
    if(isset($_GET["get_id"])){
        $id = $_GET["get_id"];
        header ("Location: update.php?get_id=$id");
        exit;
    }
    include "views/admin-product-form.view.php";

