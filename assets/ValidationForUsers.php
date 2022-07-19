<?php
    function CheckLogin($login, $id){
        if(!empty($login) && strlen($login) >= 5 && strlen($login) <= 50){
            if (preg_match("/^[a-z0-9-_]{5,50}$/i", $login)) {
                $stmt = Connection()->prepare('SELECT * FROM Users WHERE Login = ? AND IdUser != ?');
                $stmt->execute([$login, $id]);
                $count = $stmt->rowCount();
                if($count > 0){
                    echo "<p>Ошибка: Пользователь с таким логином уже есть!</p>";
                    return false;
                }
                else{
                    return true;
                }
            }
            else {
                echo '<p>В логине можно использовать только латинские буквы и цифры!</p>';
                return false;
            }
        }
        else{
            echo "\n<p>Ошибка: Длина логина не может быть меньше 5 и не больше 50 символов!</p>";
            return false;
        }
    }
    function CheckPassword($password){
        if(!empty($password) && strlen($password) >= 6 && strlen($password) <= 50){
            if (preg_match("/^[a-z0-9-_]{5,50}$/i", $password)) {
                return true;
            }
            else {
                echo '<p>В пароле можно использовать только латинские буквы и цифры!</p>';
                return false;
            }
        }
        else{
            echo "\n<p>Ошибка: Длина пароля не может быть меньше 6 и не больше 50 символов!</p>";
            return false;
        }
    }
    function CheckEmail($email){
        if(!empty($email) && strlen($email) >= 5 && strlen($email) <= 150){
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
            else {
                echo "<p>Формат ввода email не верен!</p>";
                return false;
            }
        }
        else{
            echo "\n<p>Ошибка: Длина почты не может быть меньше 5 и не больше 150 символов!</p>";
            return false;
        }
    }
    function CheckPhone($phone){
        if(!empty($phone) && strlen($phone) == 11){
            if (preg_match("/^8[0-9]{10}$/i", $phone)) {
              return true;
            } 
            else {
              echo '<p>Формат номера не соответсвует стандартам Российской Федерации!</p>';
              return false;
            }
        }
        else{
            echo "\n<p>Ошибка: Некорректный номер телефона, номер телефона должен состоять из 11 цифр и начинаться с 8!</p>";
            return false;
        }
    }
    function CheckRole($role){
        if(!empty($role)){
            return true;
        }
        else{
            echo "\n<p>Ошибка: Некорректная роль пользователя!</p>";
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
                echo "<p>Ошибка: Такого пользователя нет или он удалён!</p>";
                return false;
            }
        }
        else{
            echo "\n<p>Ошибка: Некорректный id пользователя!</p>";
            return false;
        }
    }
?>