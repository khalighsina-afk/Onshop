<?php
    $db_server ="localhost";
    $db_user = "root";
    $db_pass = "085231";
    $db_name = "onshop_db";
    $conn = "";

    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!$conn){
    echo "disconnected from the database";
    }
?>