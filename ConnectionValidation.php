<?php
    function Connection(){
        $host = 'localhost';
        $db   = 'CrudDatabase';
        $user = 'root';
        $pass = 'Password_12345';   
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $opt);
        return $pdo;
        if($pdo->connect_error){
            die("Ошибка: " . $pdo->connect_error); 
        }
        return $pdo;
    }
    function CheckLogin($login, $id){
        if(!empty($login) && strlen($login) >= 5 && strlen($login) <= 50){
            if (preg_match("/^[a-z0-9-_]{5,50}$/i", $login)) {
                $stmt = Connection()->prepare('SELECT * FROM Users WHERE Login = ? AND IdUser != ?');
                $stmt->execute([$login, $id]);
                $count = $stmt->rowCount();
                if($count > 0){
                    echo "Ошибка: Пользователь с таким логином уже есть!";
                    return false;
                }
                else{
                    return true;
                }
            }
            else {
                echo 'В логине можно использовать только латинские буквы и цифры!';
                return false;
            }
        }
        else{
            echo "\nОшибка: Длина логина не может быть меньше 5 и не больше 50 символов!";
            return false;
        }
    }
    function CheckPassword($password){
        if(!empty($password) && strlen($password) >= 5 && strlen($password) <= 50){
            if (preg_match("/^[a-z0-9-_]{5,50}$/i", $password)) {
                return true;
            }
            else {
                echo 'В пароле можно использовать только латинские буквы и цифры!';
                return false;
            }
        }
        else{
            echo "\nОшибка: Длина пароля не может быть меньше 5 и не больше 50 символов!";
            return false;
        }
    }
    function CheckEmail($email){
        if(!empty($email) && strlen($email) >= 5 && strlen($email) <= 150){
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
            else {
                echo "Формат ввода email не верен!";
                return false;
            }
        }
        else{
            echo "\nОшибка: Длина почты не может быть меньше 5 и не больше 150 символов!";
            return false;
        }
    }
    function CheckPhone($phone){
        if(!empty($phone) && strlen($phone) == 11){
            if (preg_match("/^8[0-9]{10}$/i", $phone)) {
              return true;
            } 
            else {
              echo 'Формат номера не соответсвует стандартам Российской Федерации!';
              return false;
            }
        }
        else{
            echo "\nОшибка: Некорректный номер телефона, номер телефона должен состоять из 11 цифр и начинаться с 8!";
            return false;
        }
    }
    function CheckRole($role){
        if(!empty($role)){
            return true;
        }
        else{
            echo "\nОшибка: Некорректная роль пользователя!";
            return false;
        }
    }
    function CheckIdUser($id){
        if(!empty($id)){
            $stmt = Connection()->prepare('SELECT * FROM Users WHERE IdUser = ? AND DeleteAt IS NULL');
            $stmt->execute([$id]);
            $count = $stmt->rowCount();
            if($count == 1){
                return true;
            }
            else{
                echo "Ошибка: Такого пользователя нет или он удалён!";
                return false;
            }
        }
        else{
            echo "\nОшибка: Некорректный id пользователя!";
            return false;
        }
    }
?>