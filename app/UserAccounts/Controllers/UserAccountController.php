<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Models/UserAccountModel.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Users/Validation/ValidationForUsers.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Services/imageUpload.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Core/Helpers/Pagination.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Courses/Validation/ValidationForCourses.php');

class UserAccountController
{
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
        $this->ClearCustomData();
        unset($_SESSION['errorArray']);
        $id = $this->GetUserIdFromSession();
        $model = new UserAccountModel();

        $recordCount = $model->CounterMyCourses($id);
        $paginationUrl = "courses";

        $pag = new Pagination();
        $PageCount = $pag->CalculatePagParams($recordCount);
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/Core/Helpers/PaginationView.php');
        $stmt = $model->GetUserCourses($id, $_GET['list'], $PageCount);

        require_once ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Views/UserCoursesView.php');
    }

    public function ShowListCourses()
    {
        $this->ClearCustomData();
        unset($_SESSION['errorArray']);
        $model = new UserAccountModel();

        $recordCount = $model->CounterAllCourses();
        $paginationUrl = "listcourses";

        $pag = new Pagination();
        $PageCount = $pag->CalculatePagParams($recordCount);
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/Core/Helpers/PaginationView.php');
        $stmt = $model->GetAllCourses($_GET['list'], $PageCount);

        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/UserAccounts/Views/ListCoursesView.php');
    }

    public function ShowListUsers()
    {
        $this->ClearCustomData();
        unset($_SESSION['errorArray']);
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

                if(isset($_FILES['imageUserEditer']) && strlen($_FILES['imageUserEditer']['name']) > 0) {
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
                    header("Refresh:0; url=http://localhost/myprofile/update"); die;
                }
            } else {
                header("Refresh:0; url=http://localhost/myprofile/update"); die;
            }
        } else {
            if($this->CheckDataValidation( $iduser, $login, $password, $email, $phone)){
                $model = new UserAccountModel();
                $result = $model->UpdateUserWithPassword($login, $password, $email, $phone, $iduser);

                if(isset($_FILES['imageUserEditer']) && strlen($_FILES['imageUserEditer']['name']) > 0) {
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
                    header("Refresh:0; url=http://localhost/myprofile/update"); die;
                }
            } else {
                header("Refresh:0; url=http://localhost/myprofile/update"); die;
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
        $_SESSION['customLogin'] = $login;
        $_SESSION['customEmail'] = $email;
        $_SESSION['customPhone'] = $phone;
    }

    public function ClearCustomData()
    {
        unset($_SESSION['customCourseName']);
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

    public function DeleteMyCourse()
    {
        $model = new UserAccountModel();
        $courseId = $this->GetIdFromURL();
        $userId = $this->GetUserIdFromSession();
        $result = $model->DeleteMyCourse($courseId, $userId);
        if(!$result) {
            $this->alertMessage("Вы не можете удалить чужой курс!");
        }
        header("Refresh:0; url=http://localhost/courses");
    }

    public function RecoverMyCourse()
    {
        $model = new UserAccountModel;
        $courseId = $this->GetIdFromURL();
        $userId = $this->GetUserIdFromSession();
        $result = $model->RecoverMyCourse($courseId, $userId);
        if(!$result) {
            $this->alertMessage("Вы не можете удалить чужой курс!");
        }
        header("Refresh:0; url=http://localhost/courses");
    }

    public function ShowUpdateMyCourse()
    {
        $_POST['idCourseForEdit'] = $this->GetIdFromURL();
        $model = new UserAccountModel();
        $userId = $this->GetUserIdFromSession();

        $stmt = $model->GetSelectedCourse($_POST['idCourseForEdit']);
        while ($row = $stmt->fetch())
        {
            $_POST['course'] = $row['course_name'];
            $_POST['content'] = json_decode($row['content'], JSON_FORCE_OBJECT);
            $json = json_decode($row['content'], JSON_FORCE_OBJECT);
        }

        if(isset($_POST["btnAddElement"])) {
            $this->ContentAddElement($json, $userId);
        }

        if(isset($_POST['btnUpdateElement'])){
            $this->ContentUpdateElement($json, $userId);
        }

        if(isset($_POST['btnDeleteElement'])) {
            $this->ContentDeleteElement($json, $userId);
        }

        require ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Views/EditMyCourseView.php');
    }

    public function ContentAddElement($json, int $userId)
    {
        $model = new UserAccountModel();
        $addarray = ["type" => htmlspecialchars($_POST["addType"], ENT_QUOTES), "content" => htmlspecialchars($_POST["addContent"], ENT_QUOTES)];
        array_push($json, $addarray);

        $json = array_values($json);
        $json = json_encode($json, JSON_FORCE_OBJECT);
        $model->WorkWithMyElement($json, $_POST['idCourseForEdit'], $userId);
        unset($_POST["btnAddElement"]);
        header("Refresh:0; url=http://localhost/courses/".$_POST['idCourseForEdit']."/update");
        die;
    }

    public function ContentUpdateElement($json, int $userId)
    {
        $model = new UserAccountModel();
        $id = (int)$_POST['ElementId'];

        $newElement = [["type" => htmlspecialchars($_POST['updateType'], ENT_QUOTES),"content" => htmlspecialchars($_POST['updateContent'], ENT_QUOTES)]];
        $json[$id] = $newElement[0];

        $json = array_values($json);
        $json = json_encode($json, JSON_FORCE_OBJECT);
        $model->WorkWithMyElement($json, $_POST['idCourseForEdit'], $userId);
        unset($_POST['btnUpdateElement']);
        header("Refresh:0; url=http://localhost/courses/".$_POST['idCourseForEdit']."/update");
        die;
    }

    public function ContentDeleteElement($json, int $userId)
    {
        $model = new UserAccountModel();
        $id = (int)$_POST['ElementId'];
        unset($json[$id]);

        $json = array_values($json);
        $json = json_encode($json, JSON_FORCE_OBJECT);
        $model->WorkWithMyElement($json, $_POST['idCourseForEdit'], $userId);
        unset($_POST['btnDeleteElement']);
        header("Refresh:0; url=http://localhost/courses/".$_POST['idCourseForEdit']."/update");
        die;
    }

    public function CheckCourseDataValidation(int $id, string $name, int $author)
    {
        $validation = new ValidationForCourses();
        if($id == -1){
            $idResult = true;
        } else {
            $idResult = $validation->CheckCourseId($id);
        }
        $nameResult = $validation->CheckCourseName($name);
        $authorResult = $validation->CheckAuthor($author);
        //$contentResult = $validation->CheckContent($content);
        $_SESSION['errorArray'] = $validation->OutputErrors();
        if($idResult && $nameResult && $authorResult /*&& $contentResult*/){
            return true;
        } else {
            return false;
        }
    }

    public function TryUpdateMyCourse()
    {
        unset($_SESSION['errorArray']);
        $userId = $this->GetUserIdFromSession();

        $idcourse = $_POST['idCourseForEdit'];
        $courseName = $_POST['EditFormCourse'];

        if (isset($_POST['idCourseForEdit']) && isset($_POST['EditFormCourse'])) {
            if(!$this->CheckCourseDataValidation($idcourse, $courseName, $userId)){
                header("Refresh:0; url=http://localhost/courses/".$_POST['idCourseForEdit']."/update"); die;
            } else {
                $model = new UserAccountModel();
                $result = $model->UpdateMyCourse(htmlspecialchars($_POST['EditFormCourse'], ENT_QUOTES), $_POST['idCourseForEdit'], $userId);
                if ($result) {
                    $this->ClearCustomData();
                    unset($_SESSION['errorArray']);
                    $this->alertMessage("Курс успешно изменён!");
                    header("Refresh:0; url=http://localhost/courses");
                    die;
                } else {
                    $this->alertMessage("Ошибка: Не удалось изменить курс, повторите попытку позже!");
                    header("Refresh:0; url=http://localhost/courses/".$_POST['idCourseForEdit']."/update");
                    die;
                }
            }
        } else {
            $this->alertMessage("Ошибка: Все поля должны быть заполнены!");
            header("Refresh:0; url=http://localhost/courses/".$_POST['idCourseForEdit']."/update"); die;
        }
    }

    public function ShowSelectedUser()
    {
        $model = new UserAccountModel();
        $userId = $this->GetIdFromURL();
        $stmt = $model->GetSelectedUser($userId);
        require ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Views/SelectedUserView.php');
    }

    public function ShowCreateMyCourse()
    {
        require ($_SERVER['DOCUMENT_ROOT'].'/app/UserAccounts/Views/CreateMyCourseView.php');
    }

    public function SaveCourseNameData(string $name)
    {
        $_SESSION['customCourseName'] = $name;
    }

    public function TryCreateMyCourse()
    {
        unset($_SESSION['errorArray']);
        if (isset($_POST['CreateFormCourse'])) {
            $this->SaveCourseNameData($_POST['CreateFormCourse']);
            $idAuthor = $this->GetUserIdFromSession();
            $idAccessForCreate = -1; //
            if(!$this->CheckCourseDataValidation($idAccessForCreate, $_POST['CreateFormCourse'], $idAuthor)){
                header("Refresh:0; url=http://localhost/courses/create"); die;
            } else {
                $model = new CourseModel();
                $result = $model->CreateCourse(htmlspecialchars($_POST['CreateFormCourse'], ENT_QUOTES), $idAuthor);
                if ($result) {
                    $this->ClearCustomData();
                    unset($_SESSION['errorArray']);
                    $this->alertMessage("Курс успешно создан!");
                    header("Refresh:0; url=http://localhost/courses/create");
                    die;
                } else {
                    $this->alertMessage("Ошибка: Не удалось создать курс, повторите попытку позже!");
                    header("Refresh:0; url=http://localhost/courses/create");
                    die;
                }
            }
        } else {
            $this->alertMessage("Ошибка: Все поля должны быть заполнены!");
            header("Refresh:0; url=http://localhost/courses/create"); die;
        }
    }
}