<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config/links.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Authorizations/Models/AuthorizationModel.php');

//Вывод сообщения
function alertMessage($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
}

class AuthorizationController
{
//    public function __construct()
//    {
//        $this->CheckSession();
//    }

    public function CheckSession()
    {
        session_start();
        if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1) {
            header("Refresh:0; url=adminpanel");
            die;
        }
        if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 2) {
            header("Refresh:0; url=myprofile");
            die;
        }
    }

    public function ShowAuthorization()
    {
        $this->CheckSession();
        require $_SERVER['DOCUMENT_ROOT'] . '/app/Authorizations/Views/AuthorizationView.php';
    }
    public function TryAuthorization()
    {
        $this->CheckSession();
        $enterLogin = $_POST['loginEnter']; //можно ли сразу передавать?
        $enterPassword = $_POST['passwordEnter'];
        $model = new AuthorizationModel();
        $enterResult = $model->CheckUser($enterLogin, $enterPassword);
        if($enterResult == "admin"){
            header("Refresh:0; url=adminpanel");
            die;
        } elseif($enterResult == "user"){
            header("Refresh:0; url=myprofile");
            die;
        } else{
            alertMessage("Логин или пароль введён неверно!");
            header("Refresh:0; url=auth");
            die;
        }
    }

    public function LogOut()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] ."/app/Authorizations/Services/EndSession.php";
        $closeSession = new EndSession();
        $closeSession->ServiceEndSession();
        header("Refresh:0; url=auth");
        die;
    }
}