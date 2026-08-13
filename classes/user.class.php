<?php
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

        //get user
        $sql = "SELECT * FROM users WHERE user_name = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $name]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        //check user exist
        if(!$user) {
            return false;
        }

        //check if user is locked.
        if($user['locked_until'] && strtotime($user['locked_until']) >= time()){
            return 'locked';
        }

        //verify password
        if(password_verify($password, $user['user_password'])){
            //resetting failed attempts
            $resetSql= "UPDATE users 
                        SET failed_attempts=0, locked_until= NULL
                        WHERE user_id = :id";
            $resetStmt= $pdo->prepare($resetSql);
            $resetStmt->execute([':id' => $user['user_id']]);
            return $user;
        }else {
            $failedAttempts = ($user['failed_attempts'] ?? 0) + 1 ;

            //check if should lock
            if($failedAttempts >= 5){
                $lockedUntil = date ('Y-m-d H:i:s', strtotime('+5 minutes'));
                $lockSql= "UPDATE users 
                           SET failed_attempts = :attempts, locked_until= :locked
                           WHERE user_id= :id";
                $lockStmt = $pdo->prepare($lockSql);
                $lockStmt->execute([
                   ':attempts'=> $failedAttempts,
                   ':locked'=> $lockedUntil,
                   ':id' => $user['user_id']
                ]);
                return 'locked';
            }else{
                $updateSql = "UPDATE users
                              SET failed_attempts= :attempts
                              WHERE user_id = :id";
                $updateStmt= $pdo->prepare($updateSql);
                $updateStmt->execute([
                    ':attempts'=> $failedAttempts,
                    ':id'=>$user['user_id']
                ]);
                return false;
            }

        }
    }

    public static function register($name, $email, $password){
        $pdo = Database::getConnection();

        //checking existing username and email
        $checkSql = "SELECT user_name,email FROM users
                     WHERE user_name=:name OR email=:email";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([
            ':name' => $name,
            ':email' => $email
            ]);
        $existing= $checkStmt->fetch();
        if($existing){
            if($existing['user_name'] === $name){
                throw new Exception("username already exists");
            }
            if($existing['email'] === $email){
                throw new Exception("email already exists");
            }
        }
        $hashed_password= password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(user_name, user_password, email)
                VALUES (:user_name, :password, :email)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_name' => $name,
            ':password' => $hashed_password,
            ':email'=> $email
        ]);
        $result=$pdo->lastInsertId();

        $loginSql = "SELECT * FROM users
                     WHERE user_id = :id";
        $loginStmt= $pdo->prepare($loginSql);
        $loginStmt->execute([":id" => $result]);

        $user = $loginStmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    //find users by id
    public static function find($id){
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM users
                WHERE user_id= :id";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }

    //update users
    public static function update($id, $name, $email):bool{
        $pdo = Database::getConnection();
        $sql = "UPDATE users 
                SET user_name = :name , email = :email
                WHERE user_id = :id";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':id' => $id
        ]);
        return $stmt->rowCount() > 0;
    }

    //promote to admin
    public static function promote($id):bool{
        $pdo= Database::getConnection();
        $sql = "UPDATE users 
                SET user_uid = 'admin'
                WHERE user_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id'=>$id]);
        return true;
    }

    //demote from admin
    public static function demote($id):bool{
        $pdo= Database::getConnection();
        $sql = "UPDATE users 
                SET user_uid = 'user'
                WHERE user_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id'=>$id]);
        return true;
    }
}