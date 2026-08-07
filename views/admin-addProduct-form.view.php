<!DOCTYPE html>
<html lang="en">
<title>ADMIN ADD PRODUCT</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<br><a href="admin.php">Back to All products-></a><br>
<form action="admin-addProduct.php" method="post">
    <label>Enter product's title:</label><br>
    <input type="text" name="name"><br>
    <label>Enter product's description: </label><br>
    <input type="text" name="descr"><br>
    <label>Enter product's price: </label><br>
    <input type="text" name="price"><br>
    <button type="submit" name="submit">Save</button>
</form>