<?php
    include ("database.php");

    //_GET product id and Link to update.php
    if(isset($_GET["product_id"])){
        $product_id = $_GET["product_id"] ;
    }
    //Fetch Data-->

    $sql = "SELECT * FROM products WHERE product_id=?";
    $stmt= mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt , "i", $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result ($stmt);
    $row = mysqli_fetch_assoc($result);

    //Editing the Data
    if(isset($_POST["submit"])){
        $product_id = $_POST["product_id_getter"];
        $product_name = filter_input(INPUT_POST ,   "product_name",   FILTER_SANITIZE_SPECIAL_CHARS);
        $product_descr = filter_input(INPUT_POST ,  "product_descr", FILTER_SANITIZE_SPECIAL_CHARS);
        $product_price = filter_input(INPUT_POST ,  "product_price", FILTER_SANITIZE_SPECIAL_CHARS);

        if(!empty($product_name) && !empty($product_descr) && !empty($product_price)){
            $sql = "UPDATE products SET product_name=?, product_descr=?, product_price=? WHERE product_id=?;";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssdi", $product_name, $product_descr, $product_price, $product_id);
            mysqli_stmt_execute($stmt);
            header ("Location: admin.php");
        }else{
            echo "Please fill all the fields.";
        }
    mysqli_close($conn);
    }
?>
<html>
<form   action="update.php"   method="post">
    <div id="import">
        <h1>Editing Product</h1>
        <input type="hidden" name="product_id_getter" value=" <?php echo $product_id;?> ">
        <label>enter the new  name: </label>        <br>
        <input type="text" name="product_name" value="<?php echo htmlspecialchars($row["product_name"]);    ?>  "> <br>
        <label>enter new  description: </label>      <br>
        <input type="text" name="product_descr" value="<?php echo htmlspecialchars($row["product_descr"]);  ?>" > <br>
        <label>enter new price: </label>                 <br>
        <input type="text" name="product_price" value="<?php echo htmlspecialchars($row["product_price"]);  ?>" > <br>
        <input type="submit" name="submit" value="save"> <br>
    </div>
</form>
</html>