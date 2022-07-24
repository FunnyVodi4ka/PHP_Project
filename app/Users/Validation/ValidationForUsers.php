<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Users/Models/UserModel.php');

class ValidationForUsers
{
    public function alertMessage($message) {
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    public function CheckUserId($id)
    {
        $model = new UserModel();
        $count = $model->SearchUserId($id);
        if($count > 0){
            return true;
        } else {
            $this->alertMessage("Ошибка: Некорректный id!");
            return false;
        }
    }

    public function CheckUserLogin($login, $id)
    {
        if(empty($login)) {
            $this->alertMessage("Ошибка: Некорректный логин!");
            return false;
        } else {
            if (preg_match("/^[a-zA-Z0-9\!\.\,\s*_-]{5,50}$/i", $login)) {
                $model = new UserModel();
                $count = $model->SearchUserLogin($login, $id);
                if($count > 0) {
                    $this->alertMessage("Ошибка: Пользователь с таким логином уже есть!");
                    return false;
                } else {
                    return true;
                }
            } else {
                $this->alertMessage("Ошибка: Логин не может быть меньше 5 и больше 50 сиволом, разрешены только латинские буквы и цифры!");
                return false;
            }
        }
    }

    public function CheckUserPassword($password)
    {
        if(!empty($password)){
            if (preg_match("/^[a-zA-Z0-9-_]{6,50}$/i", $password)) {
                return true;
            }
            else {
                $this->alertMessage("Ошибка: Пароль не может быть меньше 6 и длинее 50 символов, а также может содержать только латинские буквы и цифры!");
                return false;
            }
        }
        else{
            $this->alertMessage("Ошибка: Некорректный пароль!");
            return false;
        }
    }

    public function CheckUserEmail($email)
    {
        if(!empty($email) && strlen($email) >= 5 && strlen($email) <= 150){
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
            else {
                $this->alertMessage("Ошибка: Формат ввода email не верен!");
                return false;
            }
        }
        else{
            $this->alertMessage("Ошибка: Длина почты не может быть меньше 5 и не больше 150 символов!");
            return false;
        }
    }

    public function CheckUserPhone($phone)
    {
        if(!empty($phone) && strlen($phone) == 11){
            if (preg_match("/^8[0-9]{10}$/i", $phone)) {
                return true;
            } else {
                $this->alertMessage("Формат номера не соответсвует стандартам Российской Федерации!");
                return false;
            }
        } else {
            $this->alertMessage("Ошибка: Некорректный номер телефона, номер телефона должен состоять из 11 цифр и начинаться с 8!");
            return false;
        }
    }

    public function CheckUserRole($role)
    {
        if(!empty($role) && ($role == "Администратор" || $role == "Клиент")){
            return true;
        } else {
            $this->alertMessage("Ошибка: Некорректная роль!");
            return false;
        }
    }
}