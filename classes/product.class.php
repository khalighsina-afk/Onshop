<?php
include 'database.classes.php';
class Product{
    private static $totalproducts = 0;
    private static $connection = null;
    public int $id;
    public string $name;
    public string $descr;
    public float $price;

    public static function getAll(): array{
        $conn = Database::getConnection();
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);
        $products = [];
        while ($row = mysqli_fetch_assoc($result)) {
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
        $conn = Database::getConnection();
        $sql = "INSERT INTO products (product_name, product_descr, product_price)
                VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssd", $name, $descr, $price);
        mysqli_stmt_execute($stmt);
        return mysqli_insert_id($conn);
    }

    public static function delete($id):bool {
        $conn = Database::getConnection();
        $sql = "DELETE FROM products WHERE product_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_affected_rows($stmt) > 0;
    }

    public static function update($id, $name, $descr, $price):bool{
        $conn = Database::getConnection();
        $sql ="UPDATE products SET product_name = ?, product_descr = ?, product_price = ? 
               WHERE product_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssdi", $name, $descr, $price, $id);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_affected_rows($stmt) > 0;
    }
}

