<!DOCTYPE html>
<body>
    <form   action="admin.php"   method="post">
        <h1>ADMIN PANEL</h1>
        <div id="import">
            <label>enter the product name: <label>      <br>
            <input type="text" name="product_name">     <br>
            <label>enter product description: <label>   <br>
            <input type="text" name="product_descr">    <br>
            <label>enter product price: <label>         <br>
            <input type="text" name="product_price">    <br>
            <input type="submit" name="submit" value="submit product">         <br>
        </div>
    </form>
</body>
</html>
<?php
    include("database.php");

    if(isset($_POST["submit"])){
        $product_name = filter_input(INPUT_POST , "product_name", FILTER_SANITIZE_SPECIAL_CHARS);
        $product_descr= $_POST["product_descr"];
        $product_price= filter_input(INPUT_POST , "product_price", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        if(empty($product_price) ||  $product_price <=0){
            echo "please enter a valid price";
        }else{

            $sql= "INSERT INTO products (product_name, product_descr, product_price) VALUES ('$product_name', '$product_descr', '$product_price')";
            mysqli_query($conn, $sql);
            echo "the product {$product_name} added successfully.<br>";
            echo "product description: {$product_descr} <br>";
            echo "with the price of \${$product_price}!";
        }
    }






    mysqli_close($conn);
?>