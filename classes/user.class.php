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


    public static function login($name, $password) :bool{
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $name
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password, $user['password'])){
            return $user;
        }
        return false;
    }

    public static function register($name, $email, $password) :int{
        $pdo = Database::getConnection();
        $hashed_password= password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(user_name, $password, $email)
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