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

    public function CheckDataValidation(int $id, string $name, int $author)
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

    public function TryCreateCourse()
    {
        unset($_SESSION['errorArray']);
        if (isset($_POST['CreateFormCourse']) && isset($_POST['CreateFormAuthor'])) {
            $this->SaveCustomData($_POST['CreateFormCourse'], $_POST['CreateFormAuthor']);
            $idAccessForCreate = -1; //
            if(!$this->CheckDataValidation($idAccessForCreate, $_POST['CreateFormCourse'], (int)$_POST['CreateFormAuthor'])){
                header("Refresh:0; url=http://localhost/courses/catalog/create"); die;
            } else {
                $model = new CourseModel();
                $result = $model->CreateCourse(htmlspecialchars($_POST['CreateFormCourse'], ENT_QUOTES), $_POST['CreateFormAuthor']);
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
            $_POST['content'] = json_decode($row['content'], JSON_FORCE_OBJECT);
            $json = json_decode($row['content'], JSON_FORCE_OBJECT);
        }

        if(isset($_POST["btnAddElement"])) {
            $this->ContentAddElement($json);
        }

        if(isset($_POST['btnUpdateElement'])){
            $this->ContentUpdateElement($json);
        }

        if(isset($_POST['btnDeleteElement'])) {
            $this->ContentDeleteElement($json);
        }

        require ($_SERVER['DOCUMENT_ROOT'].'/app/Courses/Views/EditCourseView.php');
    }

    public function ContentAddElement($json)
    {
        $model = new CourseModel();
        $addarray = ["type" => htmlspecialchars($_POST["addType"], ENT_QUOTES), "content" => htmlspecialchars($_POST["addContent"], ENT_QUOTES)];
        array_push($json, $addarray);

        $json = array_values($json);
        $json = json_encode($json, JSON_FORCE_OBJECT);
        $model->WorkWithElement($json, $_POST['idCourseForEdit']);
        unset($_POST["btnAddElement"]);
        header("Refresh:0; url=http://localhost/courses/catalog/".$_POST['idCourseForEdit']."/update");
        die;
    }

    public function ContentUpdateElement($json)
    {
        $model = new CourseModel();
        $id = (int)$_POST['ElementId'];

        $newElement = [["type" => htmlspecialchars($_POST["addType"], ENT_QUOTES), "content" => htmlspecialchars($_POST["addContent"], ENT_QUOTES)]];
        $json[$id] = $newElement[0];

        $json = array_values($json);
        $json = json_encode($json, JSON_FORCE_OBJECT);
        $model->WorkWithElement($json, $_POST['idCourseForEdit']);
        unset($_POST['btnUpdateElement']);
        header("Refresh:0; url=http://localhost/courses/catalog/".$_POST['idCourseForEdit']."/update");
        die;
    }

    public function ContentDeleteElement($json)
    {
        $model = new CourseModel();
        $id = (int)$_POST['ElementId'];
        unset($json[$id]);

        $json = array_values($json);
        $json = json_encode($json, JSON_FORCE_OBJECT);
        $model->WorkWithElement($json, $_POST['idCourseForEdit']);
        unset($_POST['btnDeleteElement']);
        header("Refresh:0; url=http://localhost/courses/catalog/".$_POST['idCourseForEdit']."/update");
        die;
    }

    public function TryUpdateCourse()
    {
        unset($_SESSION['errorArray']);

        $idcourse = $_POST['idCourseForEdit'];
        $courseName = $_POST['EditFormCourse'];
        $idauthor = $_POST['EditFormAuthor'];

        $this->SaveCustomData($courseName, $idauthor);
        if (isset($_POST['idCourseForEdit']) && isset($_POST['EditFormCourse']) && isset($_POST['EditFormAuthor'])) {
            if(!$this->CheckDataValidation($idcourse, $courseName, $idauthor)){
                header("Refresh:0; url=http://localhost/courses/catalog/".$_POST['idCourseForEdit']."/update"); die;
            } else {
                $model = new CourseModel();
                $result = $model->UpdateCourse(htmlspecialchars($_POST['EditFormCourse'], ENT_QUOTES), $_POST['EditFormAuthor'], $_POST['idCourseForEdit']);
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

    public function SaveCustomData(string $courseName, $idauthor)
    {
        $_SESSION['customCourse'] = $courseName;
        $_SESSION['customAuthor'] = $idauthor;
    }

    public function ClearCustomData()
    {
        unset($_SESSION['customCourse']);
        unset($_SESSION['customAuthor']);
        unset($_SESSION['customContent']);
    }
}