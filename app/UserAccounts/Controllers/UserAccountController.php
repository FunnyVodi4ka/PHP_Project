<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Models/UserAccountModel.php');

class UserAccountController
{
    public function GetIdFromURL(){
        $uri = $_SERVER['REQUEST_URI'];
        $parseUri = explode('/', $uri);
        if(count($parseUri) == 4) { //строгое сравнение
            return (int)$parseUri[2];
        }
        //return
        //name метод
    }

    public function GetUserIdFromSession()
    {
        session_start();
        $id = (int)$_SESSION["is_userid"];
        return $id;
    }

    public function ShowUserAccount()
    {
        $id = (int)$this->GetUserIdFromSession();
        $model = new UserAccountModel();
        $stmt = $model->GetUserData($id);
        require_once ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Views/UserAccountView.php');
    }

    public function ShowMyCourses()
    {
        $id = (int)$this->GetUserIdFromSession();
        $model = new UserAccountModel();
        $stmt = $model->GetUserCourses($id);
        require_once ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Views/UserCoursesView.php');
    }

    public function ShowListUsers()
    {
        $model = new UserAccountModel();
        $stmt = $model->GetAllUsers();
        require_once ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Views/ListUsersView.php');
    }

    public function ShowEditProfile()
    {
        $id = (int)$this->GetUserIdFromSession();
        $model = new UserAccountModel();
        $stmt = $model->GetUserData($id);
        require_once ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Views/UserAccountEditView.php');
    }

    public function ShowSelectedCourse()
    {
        $model = new UserAccountModel();
        $courseId = $this->GetIdFromURL();
        $stmt = $model->GetSelectedCourse($courseId);
        require ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Views/SelectedCourseView.php');
    }
}