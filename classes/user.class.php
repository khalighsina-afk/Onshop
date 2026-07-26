<?php
include 'database.class.php';
class User {
    private static $totalusers = 0;
    private static $connection = 0;
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $uid;


    public static function login($name, $password) {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM users WHERE user_name = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $name]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password, $user['user_password'])){
            return $user;
        }
        return false;
    }

    public static function register($name, $email, $password){
        $pdo = Database::getConnection();
        $hashed_password= password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(user_name, user_password, email)
                VALUES (:user_name, :password, :email)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_name' => $name,
            ':password' => $hashed_password,
            ':email'=> $email
        ]);
        return (int)$pdo->lastInsertId();
    }


}