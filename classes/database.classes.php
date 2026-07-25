<?php

class Database {
    private static $connection = null;
    public static function getConnection(){
        if(self::$connection === null){
            $host = '127.0.0.1';
            $user = 'root';
            $pass = '';
            $db= 'onshop_db';

            self::$connection = mysqli_connect($host, $user, $pass, $db);
            if(!self::$connection){
                die("Connection failed: " . mysqli_connect_error());
            }
        }
        return self::$connection;
    }
}