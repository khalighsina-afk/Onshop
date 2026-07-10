<?php include("database.php"); ?>
<!DOCTYPE html>
<body>
    <form   action="admin.php"   method="post">
        <div id="import">
            <h1>ADMIN PANEL</h1>
            <label>enter the product name: <label>      <br>
            <input type="text" name="product_name">     <br>
            <label>enter product description: <label>   <br>
            <input type="text" name="product_descr">    <br>
            <label>enter product price: <label>         <br>
            <input type="text" name="product_price">    <br>
            <input type="submit" name="submit" value="submit product">         <br>
        </div>
        </p>
    </form>
</body>
</html>
<?php
    //import to the data base -->

    $sql          = "INSERT INTO products (product_name, product_descr, product_price) VALUES ( ?, ?, ?)";
    $stmt         = mysqli_stmt_init($conn);
    //entering data -->
    if(isset($_POST["submit"])){
        $product_name = filter_input(INPUT_POST , "product_name", FILTER_SANITIZE_SPECIAL_CHARS);
        $product_descr= $_POST["product_descr"];
        $product_price= filter_input(INPUT_POST , "product_price", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        if(empty ($product_name)){
            echo "Please enter the product's name or title.";
        }elseif(empty ($product_descr)){
            echo "Please enter the product description.";
        }elseif(empty($product_price) ||  $product_price <=0){
            echo "please enter a valid price";
        }elseif(!mysqli_stmt_prepare($stmt, $sql)){
            echo "SQL error!";
        }else{
            mysqli_stmt_bind_param($stmt, "ssd", $product_name, $product_descr, $product_price);
            mysqli_stmt_execute($stmt);
            echo "the product {$product_name} added successfully.<br>";
            echo "product description: {$product_descr} <br>";
            echo "with the price of \${$product_price}!<br>";

        }
    }



    //Products form Database -- >
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);
    if(isset($_POST["delete_btn"])){
        $product_id = $_POST["product_id_getter"];
        $sql = "DELETE FROM products WHERE product_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        header("Location: admin.php");
        exit;
    }
    if(mysqli_num_rows($result) <=0 ){
        echo "There is no product submitted";
    }else{
        while($row= mysqli_fetch_assoc($result)){ ?>
            <div>
                <p>
                    ============================================================ <br>
                    Product ID = <?php echo $row["product_id"]; ?>               <br>
                    Product name = <?php echo $row["product_name"]; ?>           <br>
                    Product description = <?php echo $row["product_descr"]; ?>   <br>
                    Price = $<?php echo $row["product_price"]; ?>                <br>
                </p>
                <form action="admin.php" method="post">
                    <input type="hidden" name="product_id_getter"
                    value= "<?php echo $row["product_id"] ; ?>"  > <br>
                    <button type="submit" name="delete_btn">Delete</button>
                </form>
                <form action="admin.php" method="get">
                <a href="update.php?product_id=<?php echo $row["product_id"]; ?> " >
                <button type="button">Update</button> </a>
                </form>

            </div>
<?php   }
    }
    mysqli_close($conn);
?>