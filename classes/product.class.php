<?php
include 'database.class.php';
class Product{
    private static $totalproducts = 0;
    private static $connection = null;
    public int $id;
    public string $name;
    public string $descr;
    public float $price;

    public static function getAll(): array{
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM products";
        $stmt = $pdo->query($sql);
        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $product = new Product();
            $product->id = $row['product_id'];
            $product->name = $row['product_name'];
            $product->descr = $row['product_descr'];
            $product->price = $row['product_price'];
            $products[] = $product;
        }
        return $products;
    }

    public static function insert($name, $descr, $price): int{
        $pdo = Database::getConnection();
        $sql = "INSERT INTO products (product_name, product_descr, product_price)
                VALUES (:name, :decr, :price)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name'=> $name,
            'descr' => $descr,
            ':price' => $price
        ]);
        return (int)$pdo->lastInsertId();
    }

    public static function delete($id):bool
    {
        $pdo = Database::getConnection();
        $sql = "DELETE FROM products WHERE product_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;

    }
    public static function update($id, $name, $descr, $price):bool{
        $pdo = Database::getConnection();
        $sql ="UPDATE products 
               SET product_name = :name, product_descr = :descr, product_price = :price 
               WHERE product_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name'=> $name,
            'descr'=>$descr,
            'price'=>$price,
            'id'=>$id
        ]);
        return $stmt->rowCount() > 0;
    }
}

