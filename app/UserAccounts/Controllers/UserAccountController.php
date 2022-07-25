<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Models/UserAccountModel.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Users/Validation/ValidationForUsers.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Services/imageUpload.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Core/Helpers/Pagination.php');

class UserAccountController
{
    function alertMessage($message) {
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    public function __construct()
    {
        $this->CheckSession();
    }

    public function CheckSession()
    {
        session_start();
        if ($_SESSION["is_auth"]) {
            return true;
        } else {
            header("Refresh:0; url=http://localhost/auth"); die;
            return false;
        }
    }

    public function GetIdFromURL(){
        $uri = $_SERVER['REQUEST_URI'];
        $parseUri = explode('/', $uri);
        if(count($parseUri) == 4) {
            return (int)$parseUri[2];
        }
        return 0;
    }

    public function GetUserIdFromSession()
    {
        session_start();
        $id = (int)$_SESSION["is_userid"];
        return $id;
    }

    public function ShowUserAccount()
    {
        $this->ClearCustomData();
        unset($_SESSION['errorArray']);
        $id = $this->GetUserIdFromSession();
        $model = new UserAccountModel();
        $stmt = $model->GetUserData($id);
        require_once ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Views/UserAccountView.php');
    }

    public function ShowMyCourses()
    {
        $id = $this->GetUserIdFromSession();
        $model = new UserAccountModel();
        $stmt = $model->GetUserCourses($id);
        require_once ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Views/UserCoursesView.php');
    }

    public function ShowListUsers()
    {
        $model = new UserAccountModel();

        $recordCount = $model->CounterAllUsers();
        $paginationUrl = "listusers";

        $pag = new Pagination();
        $PageCount = $pag->CalculatePagParams($recordCount);
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/Core/Helpers/PaginationView.php');
        $stmt = $model->GetAllUsers($_GET['list'], $PageCount);

        require_once ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Views/ListUsersView.php');
    }

    public function ShowEditProfile()
    {
        $id = $this->GetUserIdFromSession();
        $model = new UserAccountModel();
        $stmt = $model->GetUserData($id);
        require_once ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Views/UserAccountEditView.php');
    }

    public function TryEditProfile()
    {
        unset($_SESSION['errorArray']);
        $iduser = (int)$_POST['iduserUserEditer'];
        $login = $_POST["loginUserEditer"];
        $password = $_POST["passwordUserEditer"];
        $email = $_POST["emailUserEditer"];
        $phone = $_POST["phoneUserEditer"];

        $this->SaveCustomData($login, $email, $phone);
        if(empty($password)){
            if($this->CheckDataValidation( $iduser, $login, "wasdwasd", $email, $phone)){
                $model = new UserAccountModel();
                $result = $model->UpdateUserWithoutPassword($login, $email, $phone, $iduser);

                if(isset($_FILES['imageUserEditer'])) {
                    $uploader = new ImageUpload();
                    $uploader->Upload($iduser);
                }

                if($result) {
                    $this->ClearCustomData();
                    unset($_SESSION['errorArray']);
                    $this->alertMessage("Данные успешно изменены!");
                    header("Refresh:0; url=http://localhost/myprofile"); die;
                } else {
                    $this->alertMessage("Ошибка: Не удалось изменить пользователя, повторите попытку позже!");
                    header("Refresh:0; url=http://localhost/myprofile/edit"); die;
                }
            } else {
                header("Refresh:0; url=http://localhost/myprofile/edit"); die;
            }
        } else {
            if($this->CheckDataValidation( $iduser, $login, $password, $email, $phone)){
                $model = new UserAccountModel();
                $result = $model->UpdateUserWithPassword($login, $password, $email, $phone, $iduser);

                if(isset($_FILES['imageUserEditer'])) {
                    $uploader = new ImageUpload();
                    $uploader->Upload($iduser);
                }

                if($result) {
                    $this->ClearCustomData();
                    unset($_SESSION['errorArray']);
                    $this->alertMessage("Данные успешно изменены!");
                    header("Refresh:0; url=http://localhost/myprofile"); die;
                } else {
                    $this->alertMessage("Ошибка: Не удалось изменить пользователя, повторите попытку позже!");
                    header("Refresh:0; url=http://localhost/myprofile/edit"); die;
                }
            } else {
                header("Refresh:0; url=http://localhost/myprofile/edit"); die;
            }
        }
    }

    public function CheckDataValidation(int $id, string $login, string $password, string $email, string $phone)
    {
        $validation = new ValidationForUsers();
        $idResult = $validation->CheckUserId($id);
        $loginResult = $validation->CheckUserLogin($login, $id);
        $passwordResult = $validation->CheckUserPassword($password);
        $emailResult = $validation->CheckUserEmail($email);
        $phoneResult = $validation->CheckUserPhone($phone);

        $_SESSION['errorArray'] = $validation->OutputErrors();

        if($idResult && $loginResult && $passwordResult && $emailResult && $phoneResult){
            return true;
        } else {
            return false;
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

    public function ShowSelectedCourse()
    {
        $model = new UserAccountModel();
        $courseId = $this->GetIdFromURL();
        $stmt = $model->GetSelectedCourse($courseId);
        require ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Views/SelectedCourseView.php');
    }
}