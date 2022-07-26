<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Courses/Models/CourseModel.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Courses/Validation/ValidationForCourses.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Core/Helpers/Pagination.php');

class CourseController
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
        if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1) {
            return true;
        } else {
            header("Refresh:0; url=http://localhost/auth"); die;
            return false;
        }
    }

    public function GetIdFromURL(){
        $uri = $_SERVER['REQUEST_URI'];
        $parseUri = explode('/', $uri);
        if(count($parseUri) == 5) {
            return (int)$parseUri[3];
        }
        return 0;
    }

    public function GetIdFromSession()
    {
        session_start();
        $myId = (int)$_SESSION["is_userid"];
        return $myId;
    }

    public function ShowAllCourses()
    {
        unset($_SESSION['errorArray']);
        $this->ClearCustomData();
        $model = new CourseModel();

        $recordCount = $model->CounterAllCourses();
        $paginationUrl = "courses/catalog";

        $pag = new Pagination();
        $PageCount = $pag->CalculatePagParams($recordCount);
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/Core/Helpers/PaginationView.php');
        $stmt = $model->GetAllCourses($_GET['list'], $PageCount);

        require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Courses/Views/AllCoursesView.php');
    }

    public function ShowSelectedCourse()
    {
        $model = new CourseModel;
        $courseId = $this->GetIdFromURL();
        $stmt = $model->GetSelectedCourse($courseId);
        require ($_SERVER['DOCUMENT_ROOT'].'/app/Courses/Views/SelectedCourseView.php');
    }

    public function DeleteCourse()
    {
        $model = new CourseModel;
        $courseId = $this->GetIdFromURL();
        $model->DeleteCourse($courseId);
        header("Refresh:0; url=http://localhost/courses/catalog");
    }

    public function RecoverCourse()
    {
        $model = new CourseModel;
        $courseId = $this->GetIdFromURL();
        $model->RecoverCourse($courseId);
        header("Refresh:0; url=http://localhost/courses/catalog");
    }

    public function ShowCreateCourse()
    {
        require ($_SERVER['DOCUMENT_ROOT'].'/app/Courses/Views/CreateCourseView.php');
    }

    public function CheckDataValidation(int $id, string $name, int $author, string $content)
    {
        $validation = new ValidationForCourses();
        if($id == -1){
            $idResult = true;
        } else {
            $idResult = $validation->CheckCourseId($id);
        }
        $nameResult = $validation->CheckCourseName($name);
        $authorResult = $validation->CheckAuthor($author);
        $contentResult = $validation->CheckContent($content);
        $_SESSION['errorArray'] = $validation->OutputErrors();
        if($idResult && $nameResult && $authorResult && $contentResult){
            return true;
        } else {
            return false;
        }
    }

    public function TryCreateCourse()
    {
        unset($_SESSION['errorArray']);
        if (isset($_POST['CreateFormCourse']) && isset($_POST['CreateFormAuthor']) && isset($_POST['CreateFormContent'])) {
            $this->SaveCustomData($_POST['CreateFormCourse'], $_POST['CreateFormAuthor'], $_POST['CreateFormContent']);
            $idAccessForCreate = -1; //
            if(!$this->CheckDataValidation($idAccessForCreate, $_POST['CreateFormCourse'], (int)$_POST['CreateFormAuthor'], $_POST['CreateFormContent'])){
                header("Refresh:0; url=http://localhost/courses/catalog/create"); die;
            } else {
                $model = new CourseModel();
                $result = $model->CreateCourse($_POST['CreateFormCourse'], $_POST['CreateFormAuthor'], $_POST['CreateFormContent']);
                if ($result) {
                    $this->ClearCustomData();
                    unset($_SESSION['errorArray']);
                    $this->alertMessage("Курс успешно создан!");
                    header("Refresh:0; url=http://localhost/courses/catalog/create");
                    die;
                } else {
                    $this->alertMessage("Ошибка: Не удалось создать курс, повторите попытку позже!");
                    header("Refresh:0; url=http://localhost/courses/catalog/create");
                    die;
                }
            }
        } else {
            $this->alertMessage("Ошибка: Все поля должны быть заполнены!");
            header("Refresh:0; url=http://localhost/courses/catalog/create"); die;
        }
    }

    public function ShowUpdateCourse()
    {
        $_POST['idCourseForEdit'] = $this->GetIdFromURL();
        $model = new CourseModel();
        $stmt = $model->GetSelectedCourse($_POST['idCourseForEdit']);
        while ($row = $stmt->fetch())
        {
            $_POST['course'] = $row['course_name'];
            $_POST['author'] = (int)$row['author_id'];
            $_POST['content'] = json_decode($row['content']);
        }
        require ($_SERVER['DOCUMENT_ROOT'].'/app/Courses/Views/EditCourseView.php');
    }

    public function TryUpdateCourse()
    {
        unset($_SESSION['errorArray']);

        $idcourse = $_POST['idCourseForEdit'];
        $courseName = $_POST['EditFormCourse'];
        $idauthor = $_POST['EditFormAuthor'];
        $content = $_POST['EditFormContent'];

        $this->SaveCustomData($courseName, $idauthor, $content);
        if (isset($_POST['idCourseForEdit']) && isset($_POST['EditFormCourse']) && isset($_POST['EditFormAuthor']) && isset($_POST['EditFormContent'])) {
            if(!$this->CheckDataValidation($idcourse, $courseName, $idauthor, $content)){
                header("Refresh:0; url=http://localhost/courses/catalog/".$_POST['idCourseForEdit']."/update"); die;
            } else {
                $model = new CourseModel();
                $result = $model->UpdateCourse($_POST['EditFormCourse'], $_POST['EditFormAuthor'], $_POST['EditFormContent'], $_POST['idCourseForEdit']);
                if ($result) {
                    $this->ClearCustomData();
                    unset($_SESSION['errorArray']);
                    $this->alertMessage("Курс успешно изменён!");
                    header("Refresh:0; url=http://localhost/courses/catalog");
                    die;
                } else {
                    $this->alertMessage("Ошибка: Не удалось изменить курс, повторите попытку позже!");
                    header("Refresh:0; url=http://localhost/courses/catalog/".$_POST['idCourseForEdit']."/update");
                    die;
                }
            }
        } else {
            $this->alertMessage("Ошибка: Все поля должны быть заполнены!");
            header("Refresh:0; url=http://localhost/courses/catalog/".$_POST['idCourseForEdit']."/update"); die;
        }
    }

    public function SaveCustomData(string $courseName, $idauthor, string $content)
    {
        session_start();
        $_SESSION['customCourse'] = $courseName;
        $_SESSION['customAuthor'] = $idauthor;
        $_SESSION['customContent'] = $content;
    }

    public function ClearCustomData()
    {
        unset($_SESSION['customCourse']);
        unset($_SESSION['customAuthor']);
        unset($_SESSION['customContent']);
    }
}