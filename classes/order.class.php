<?php
class Order{
    public int $order_id;
    public int $user_id;
    public float $total;
    public int $product_id;
    public int $quantity;
    public int $price;
    public int $subtotal;


    public static function getAll($user_id){
        $pdo = Database::getConnection();
        $sql = "SELECT * 
                 FROM orders
                 WHERE user_id = :user_id";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll();
    }
    public static function insert($user_id, $total){
        $pdo = Database::getConnection();
        $sql = "INSERT INTO orders(user_id, total_amount)
                VALUES (:user_id, :total_amount)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id'=>$user_id,
            ':total_amount'=>$total]);
        return (int)$pdo->lastInsertId();
    }
    public static function find($order_id){
        $pdo = Database::getConnection();
        $sql = "SELECT *
                FROM orders
                WHERE order_id= :order_id";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([':order_id' => $order_id]);
        return $stmt->fetch();
    }

    public static function itemsInsert($order_id, $product_id, $quantity, $price, $subtotal):bool{
        $pdo = Database::getConnection();
        $sql = "INSERT INTO order_items(order_id, product_id, items_quantity, 
                                        price, subtotal_price)
                VALUES(:order_id, :product_id, :quantity, :price, :subtotal)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':order_id'=>$order_id,
            ':product_id'=>$product_id,
            ':quantity'=>$quantity,
            ':price'=>$price,
            ':subtotal'=>$subtotal
        ]);
        return (int)$pdo->lastInsertId();
    }

    public static function getItems($order_id){
        $pdo = Database::getConnection();
        $sql = "SELECT *
                FROM order_items
                WHERE order_id= :order_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':order_id' => $order_id]);
        return $stmt->fetchAll();
    }

}