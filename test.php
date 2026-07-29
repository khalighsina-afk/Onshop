<?php
include 'includes/myautoloader.includes.php';
session_start();
if($_SESSION){
    echo"login success!<br>";
    echo"Welcome ".$_SESSION['user_name']."!";
}else{
    header ("location: views/login-form.view.php");
    exit;
}
$user_name=$_SESSION['user_name'];
$user_id = $_SESSION["user_id"];

$items=Cart::showAllItems($user_id);
foreach ($items as $item){
    echo $item->quantity;



}

