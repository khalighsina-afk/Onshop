<?php
include 'includes/myautoloader.includes.php';

if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $user = User::register($name, $email, $password);
    echo "register successful";
}else {
    echo "register failed";
}
?>
    <form action="test.php" method="post">
        <input type="text" name="name"><br>
        <input type="text" name="email"><br>
        <input type="password" name="password"><br>
        <input type="submit" name="submit">
    </form>

