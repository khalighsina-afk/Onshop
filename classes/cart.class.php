<?php
class Cart{
    private static $allItems = 0;
    private static $connection = null;
    public int $user_id;
    public int $product_id;
    public string $product_name;
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
            $item->product_id = $row['product_id'];
            $item->product_name = $row['product_name'];
            $item->product_price = $row['product_price'];
            $item->quantity = $row['quantity'];
            $items []= $item;
        }
        return $items;
    }


    public static function insert($user_id, $product_id, $quantity){
        $pdo = Database::getConnection();

        //checking if the product is still in the cart
        $checkSql = "SELECT product_id 
                     FROM cart
                     WHERE user_id = :user_id AND product_id= :product_id ";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([
            ':user_id' => $user_id,
            'product_id' => $product_id]);
        $existing= $checkStmt->fetch();

        if($existing){
            //if it is, update quantity
            $updateSql = "UPDATE cart 
                          SET quantity = :quantity
                          WHERE user_id = :user_id AND product_id= :product_id";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([
                ':quantity' => $quantity,
                ':user_id' => $user_id,
                ':product_id' => $product_id
                ]);
            return $updateStmt->rowCount() > 0 ;
        }else{
            //if nor insert
            $sql = "INSERT INTO cart (user_id, product_id, quantity) 
                    VALUES (:user_id, :product_id, :quantity)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':product_id' => $product_id,
                ':quantity' => $quantity
            ]);
            return (int)$pdo->lastInsertId();
        }
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