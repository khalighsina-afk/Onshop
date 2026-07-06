<?php
    include ("database.php");
?>
<html>
<form   action="update.php"   method="post">
    <div id="import">
        <h1>Editing Product</h1>
        <label>enter the new  name: <label>      <br>
        <input type="text" name="product_name" value="<?php ?>">     <br>
        <label>enter new  description: <label>   <br>
        <input type="text" name="product_descr">    <br>
        <label>enter new price: <label>         <br>
        <input type="text" name="product_price">    <br>
        <input type="submit" name="submit" value="save">         <br>
    </div>
</form>
</html>