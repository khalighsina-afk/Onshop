<?php
include 'includes/myautoloader.includes.php';
session_start();
if($_SESSION){
    echo"login success!<br>";
    echo"Welcome ".$_SESSION['username']."!";
}else{
    header ("location: login.php");
    exit;
}
$user_name=$_SESSION['username'];
$user_id = $_SESSION["user_id"];

$items=Cart::showAllItems($user_id);
foreach ($items as $item){
    echo $item->quantity;
}

