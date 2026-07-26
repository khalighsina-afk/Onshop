<?php

class Database {
    private static $pdo = null;
    public static function getConnection() : PDO{
        if(self::$pdo === null){
            $dsn = 'mysql:host=127.0.0.1;dbname=onshop-db;charset=utf8mb4';
            self::$pdo = new PDO($dsn, 'root', '085231');
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$pdo;
    }
}