<?php
class Database {
    private static $pdo = null;
    private static $host = "127.0.0.1";
    private static $user = "root";
    private static $pass = "085231";
    private static $db="onshop_db";
    public static function getConnection() : PDO{
        if(self::$pdo === null){
            try{
                $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$db . ';charset=utf8mb4';
                self::$pdo = new PDO($dsn, self::$user, self::$pass);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,
                    PDO::FETCH_ASSOC);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                die("Database connection failed") . $e->getMessage();
            }
        }
        return self::$pdo;
    }
}