<?php include 'views/partials/head.view.php'; ?>
<?php include 'views/partials/header.view.php'; ?>
<form   action="update.php"   method="post">
    <div id="import">
        <h1>Editing Product</h1>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label>enter the new  name: </label>        <br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name);    ?>"> <br>
        <label>enter new  description: </label>      <br>
        <input type="text" name="descr" value="<?php echo htmlspecialchars($descr);  ?>" > <br>
        <label>enter new price: </label>                 <br>
        <input type="text" name="price" value="<?php echo htmlspecialchars($price);  ?>" > <br>
        <input type="submit" name="submit" value="save"> <br>
    </div>
</form>
