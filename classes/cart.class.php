<?php
include 'database.class.php';

class Cart{
    private static $allItems = 0;
    private static $connection = null;
    public int $user_id;
    public int $product_id;
    public int $product_name;
    public int $product_price;
    public int $quantity;

    public static function showAllItems($user_id){
        $pdo = Database::getConnection();
        $sql = "SELECT products.*, cart.quantity
                FROM cart 
                JOIN products ON cart.product_id = products.product_id
                WHERE cart.user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        $items = [];
        $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row){
            $item = new Cart();
            $item->user_id=$row['user_id'];
            $item->product_id = $row['product_id'];
            $item->product_name = $row['product_name'];
            $item->product_price = $row['product_price'];
            $item->quantity = $row['quantity'];
            $items []= $item;
        }
        return $items;
    }

    public static function delete($user_id, $product_id){
        $pdo = Database::getConnection();
        $sql = "DELETE FROM cart 
                WHERE user_id= :user_id AND product_id = :product_id";
        $stmt =$pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
        return $stmt->rowCount() > 0;
    }

    public static function quantity($quantity, $product_id, $user_id){
        $pdo = Database::getConnection();
        $sql = "UPDATE cart 
                SET quantity = :quantity
                WHERE product_id = :product_id AND user_id=:user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
           ':quantity' => $quantity,
           ':product_id' => $product_id,
           ':user_id' => $user_id
        ]);
        return $stmt->rowCount() > 0;
    }
}