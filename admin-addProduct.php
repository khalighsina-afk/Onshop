<?php
    include 'includes/myautoloader.includes.php';
    session_start();

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $descr= $_POST['descr'];
        $price = $_POST['price'];
        $add= Product::insert($name, $descr, $price);
        if($add){
            echo "<div class='alert alert-success'>";
            echo "<strong>Success!</strong>";
        }else{
            echo "<div class='alert alert-danger'>";
            echo "<strong>Error!</strong>";
        }
    }
    include 'views/admin-addProduct-form.view.php';

