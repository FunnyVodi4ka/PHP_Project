<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config/database.php');

class RegistrationModel
{
    public function SearchUserLogin($login, $id){
        $stmt = Connection()->prepare('SELECT * FROM users WHERE login = ? AND user_id != ?');
        $stmt->execute([$login, $id]);
        $count = $stmt->rowCount();
        return $count;
    }

    public function CreateUser(string $login, string $password, string $email, string $phone)
    {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $standardRole = 2;
        $stmt = Connection()->prepare("INSERT INTO users (login, password, email, phone, role_id) 
        VALUES (?, ?, ?, ?, ?)");
//        $stmt->bindParam(1, $login);
//        $stmt->bindParam(2, $hashPassword);
//        $stmt->bindParam(3, $email);
//        $stmt->bindParam(4, $phone);
//        $stmt->bindParam(5, $standardRole, PDO::PARAM_INT);
//        $result = $stmt->execute();
//        if($result) {
//            return true;
//        } else {
//            return false;
//        }
        if($stmt->execute([$login, $hashPassword, $email, $phone, $standardRole])){
            return true;
        } else {
            return false;
        }
    }
}