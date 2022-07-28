<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config/links.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Registrations/Models/RegistrationModel.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Registrations/Validation/ValidationForRegister.php');

class RegistrationController
{
    public function alertMessage($message) {
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    public function CheckSession()
    {
        session_start();
        if (isset($_SESSION["is_auth"]) && $_SESSION["is_role"] == 1) {
            header("Refresh:0; url=http://localhost/adminpanel");
            die;
        }
        if (isset($_SESSION["is_auth"]) && $_SESSION["is_role"] == 2) {
            header("Refresh:0; url=http://localhost/myaccount");
            die;
        }
    }

    public function ShowRegistration()
    {
        $this->CheckSession();
        require $_SERVER['DOCUMENT_ROOT'] . '/app/Registrations/Views/RegistrationView.php';
    }

    public function CheckDataValidation()
    {
        $validation = new ValidationForRegister();
        $loginResult = $validation->CheckUserLogin($_POST['loginRegister']);
        $passwordResult = $validation->CheckUserPassword($_POST['passwordRegister']);
        $emailResult = $validation->CheckUserEmail($_POST['emailRegister']);
        $phoneResult = $validation->CheckUserPhone($_POST['phoneRegister']);

        $_SESSION['errorArray'] = $validation->OutputErrors();

        if($loginResult && $passwordResult && $emailResult && $phoneResult){
            return true;
        } else {
            return false;
        }
    }

    public function TryRegistration()
    {
        unset($_SESSION['errorArray']);

        $this->CheckSession();
        $this->SaveCustomData($_POST['loginRegister'], $_POST['emailRegister'], $_POST['phoneRegister']);
        if($_POST['passwordRegister'] == $_POST["passwordSecondRegister"]) {
            if (isset($_POST['loginRegister']) && isset($_POST['passwordRegister']) &&
                isset($_POST['emailRegister']) && isset($_POST['phoneRegister'])) {
                if(!$this->CheckDataValidation()){
                    header("Refresh:0; url=http://localhost/register"); die;
                } else {
                    $model = new RegistrationModel();
                    $result = $model->CreateUser($_POST['loginRegister'], $_POST['passwordRegister'], $_POST['emailRegister'], $_POST['phoneRegister']);
                    if ($result) {
                        $this->ClearCustomData();
                        unset($_SESSION['errorArray']);
                        $this->alertMessage("Регистрация прошла успешно!");
                        header("Refresh:0; url=http://localhost/auth");
                        die;
                    } else {
                        $this->alertMessage("Ошибка: Не удалось зарегистрироваться, повторите попытку позже!");
                        header("Refresh:0; url=http://localhost/register");
                        die;
                    }
                }
            } else {
                $this->alertMessage("Ошибка: Все поля должны быть заполнены!");
                header("Refresh:0; url=http://localhost/register"); die;
            }
        } else {
            $this->alertMessage("Ошибка: Пароли не совподают, попробуйте снова!");
            header("Refresh:0; url=http://localhost/register"); die;
        }
    }

    public function SaveCustomData(string $login, string $email, string $phone)
    {
        session_start();
        $_SESSION['customLogin'] = $login;
        $_SESSION['customEmail'] = $email;
        $_SESSION['customPhone'] = $phone;
    }

    public function ClearCustomData()
    {
        unset($_SESSION['customLogin']);
        unset($_SESSION['customEmail']);
        unset($_SESSION['customPhone']);
    }
}