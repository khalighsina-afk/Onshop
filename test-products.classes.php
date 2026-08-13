<?php 

include 'classes/Database.class.php';
include 'classes/Products.class.php';


$products = Product::getAll();

echo "<h1>Products (OOP test)</h1>";
foreach($products as $product){

    echo $product->name . "- $" . $product->price . "<br>";
}