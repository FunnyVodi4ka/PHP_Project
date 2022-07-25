<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Users/Models/UserModel.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Users/Validation/ValidationForUsers.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Core/Helpers/Pagination.php');

class UserController
{
    //public $errorArray = [];

    public function alertMessage($message) {
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    public function __construct()
    {
        $this->CheckSession();
    }

    public function CheckSession()
    {
        session_start();
        if (!$_SESSION["is_auth"] && $_SESSION["is_role"] != 1) {
            header("Refresh:0; url=http://localhost/auth"); die;
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

    public function GetIdFromSession()
    {
        session_start();
        $myId = (int)$_SESSION["is_userid"];
        return $myId;
    }

    public function ShowAllUsers()
    {
        $this->ClearCustomData();
        unset($_SESSION['errorArray']);
        $model = new UserModel();

        $recordCount = $model->CounterAllUsers();
        $paginationUrl = "users";

        $pag = new Pagination();
        $PageCount = $pag->CalculatePagParams($recordCount);
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/Core/Helpers/PaginationView.php');
        $stmt = $model->GetAllUsers($_GET['list'], $PageCount);

        require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Users/Views/AllUsersView.php');
    }

    public function ShowSelectedUser()
    {
        $model = new UserModel;
        $userId = $this->GetIdFromURL();
        $stmt = $model->GetSelectedUser($userId);
        require ($_SERVER['DOCUMENT_ROOT'].'/app/Users/Views/SelectedUserView.php');
    }

    public function DeleteUser()
    {
        $userId = $this->GetIdFromURL();
        $myId = $this->GetIdFromSession();
        if($myId == $userId){
            //echo "Вы не можете удалить себя!";
            header("Refresh:0; url=http://localhost/users");
        } else {
            $model = new UserModel;
            $model->DeleteUser($userId);
            header("Refresh:0; url=http://localhost/users");
        }
    }

    public function RecoverUser()
    {
        $model = new UserModel;
        $userId = $this->GetIdFromURL();
        $model->RecoverUser($userId);
        header("Refresh:0; url=http://localhost/users");
    }

    public function ShowCreateUser()
    {
        require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Users/Views/CreateUserView.php');
    }

    public function CheckDataValidation(int $id, string $login, string $password, string $email, string $phone, string $role)
    {
        $validation = new ValidationForUsers();
        $idResult = $validation->CheckUserId($id);
        $loginResult = $validation->CheckUserLogin($login, $id);
        $passwordResult = $validation->CheckUserPassword($password);
        $emailResult = $validation->CheckUserEmail($email);
        $phoneResult = $validation->CheckUserPhone($phone);
        $roleResult = $validation->CheckUserRole($role);

        $_SESSION['errorArray'] = $validation->OutputErrors();

        if($idResult && $loginResult && $passwordResult && $emailResult && $phoneResult && $roleResult){
            return true;
        } else {
            return false;
        }
    }

    public function TryCreateUser()
    {
        unset($_SESSION['errorArray']);
        if($_POST['passwordCreater'] == $_POST["passwordSecondCreater"]) {
            if (isset($_POST['loginCreater']) && isset($_POST['passwordCreater']) &&
                isset($_POST['emailCreater']) && isset($_POST['phoneCreater']) && isset($_POST['roleCreater'])) {
                $this->SaveCustomData($_POST['loginCreater'], $_POST['emailCreater'], $_POST['phoneCreater']);
                $idAccessForCreate = $this->GetIdFromSession(); //
                if(!$this->CheckDataValidation($idAccessForCreate, $_POST['loginCreater'], $_POST['passwordCreater'], $_POST['emailCreater'], $_POST['phoneCreater'])){
                    header("Refresh:0; url=http://localhost/users/create"); die;
                } else {
                    $model = new UserModel();
                    $result = $model->CreateUser($_POST['loginCreater'], $_POST['passwordCreater'], $_POST['emailCreater'], $_POST['phoneCreater'], $_POST['roleCreater']);
                    if ($result) {
                        $this->ClearCustomData();
                        unset($_SESSION['errorArray']);
                        $this->alertMessage("Пользователь успешно создан!");
                        header("Refresh:0; url=http://localhost/users/create");
                        die;
                    } else {
                        $this->alertMessage("Ошибка: Не удалось создать пользователя, повторите попытку позже!");
                        header("Refresh:0; url=http://localhost/users/create");
                        die;
                    }
                }
            } else {
                $this->alertMessage("Ошибка: Все поля должны быть заполнены!");
                header("Refresh:0; url=http://localhost/users/create"); die;
            }
        } else {
            $this->alertMessage("Ошибка: Пароли не совподают, попробуйте снова!");
            header("Refresh:0; url=http://localhost/users/create"); die;
        }
    }

    public function ShowEditUser()
    {
        $_POST['idUserForEdit'] = $this->GetIdFromURL();
        $model = new UserModel();
        $stmt = $model->GetSelectedUser($_POST['idUserForEdit']);
        while ($row = $stmt->fetch())
        {
            $_POST['login'] = $row['login'];
            $_POST['email'] = $row['email'];
            $_POST['phone'] = $row['phone'];
            $_POST['role'] = $row['role_name'];
        }
        require ($_SERVER['DOCUMENT_ROOT'].'/app/Users/Views/EditUserView.php');
    }

    public function TryEditUser()
    {
        unset($_SESSION['errorArray']);
        $iduser = (int)$_POST['idUserForEdit'];
        $login = $_POST["loginEditer"];
        $password = $_POST["passwordEditer"];
        $email = $_POST["emailEditer"];
        $phone = $_POST["phoneEditer"];
        $role = $_POST["roleEditer"];

        $this->SaveCustomData($login, $email, $phone);
        if(empty($password)){
            if($this->CheckDataValidation( $iduser, $login, "wasdwasd", $email, $phone, $role)){
                if($_POST['idUserForEdit'] == $this->GetIdFromSession()){
                    $role = "Администратор";
                }
                $model = new UserModel();
                $result = $model->UpdateUserWithoutPassword($login, $email, $phone, $role, $iduser);
                if($result) {
                    $this->ClearCustomData();
                    unset($_SESSION['errorArray']);
                    $this->alertMessage("Пользователь успешно изменён!");
                    header("Refresh:0; url=http://localhost/users"); die;
                } else {
                    $this->alertMessage("Ошибка: Не удалось изменить пользователя, повторите попытку позже!");
                    header("Refresh:0; url=http://localhost/users/".$_POST['idUserForEdit']."/edit"); die;
                }
            } else {
                header("Refresh:0; url=http://localhost/users/".$_POST['idUserForEdit']."/edit"); die;
            }
        } else {
            if($this->CheckDataValidation( $iduser, $login, $password, $email, $phone, $role)){
                if($_POST['idUserForEdit'] == $this->GetIdFromSession()){
                    $role = "Администратор";
                }
                $model = new UserModel();
                $result = $model->UpdateUserWithPassword($login, $password, $email, $phone, $role, $iduser);
                if($result) {
                    $this->ClearCustomData();
                    unset($_SESSION['errorArray']);
                    $this->alertMessage("Пользователь успешно изменён!");
                    header("Refresh:0; url=http://localhost/users"); die;
                } else {
                    $this->alertMessage("Ошибка: Не удалось изменить пользователя, повторите попытку позже!");
                    header("Refresh:0; url=http://localhost/users/".$_POST['idUserForEdit']."/edit"); die;
                }
            } else {
                header("Refresh:0; url=http://localhost/users/".$_POST['idUserForEdit']."/edit"); die;
            }
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