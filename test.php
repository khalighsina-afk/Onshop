<?php

//include 'classes/database.classes.php';
include 'classes/product.class.php';
$products = Product::getAll();
if(isset($_POST["id_getter"])){
    $id = $_POST["id_getter"];
    Product::delete($id);
    header ('Location: test.php');
    exit;
}
foreach ($products as $product) {
    echo $product->name . "<br>";
    echo $product->price . "<br>";?>
    <form action="test.php" method="post">
        <input  type="hidden" value="<?php echo $product->id; ?>" name="id_getter">
        <button type="submit" name="delete" >Delete</button>
    </form>
<?php
}

?>
