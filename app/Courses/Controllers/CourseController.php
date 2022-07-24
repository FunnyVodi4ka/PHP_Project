<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Courses/Models/CourseModel.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Courses/Validation/ValidationForCourses.php');

class CourseController
{
    public function alertMessage($message) {
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    public function GetIdFromURL(){
        $uri = $_SERVER['REQUEST_URI'];
        $parseUri = explode('/', $uri);
        if(count($parseUri) == 4) {
            return (int)$parseUri[2];
        }
        return 0;
    }

    public function ShowAllCourses()
    {
        $model = new CourseModel();
        $stmt = $model->GetAllCourses();
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
        header("Refresh:0; url=http://localhost/courses");
    }

    public function RecoverCourse()
    {
        $model = new CourseModel;
        $courseId = $this->GetIdFromURL();
        $model->RecoverCourse($courseId);
        header("Refresh:0; url=http://localhost/courses");
    }

    public function ShowCreateCourse()
    {
        require ($_SERVER['DOCUMENT_ROOT'].'/app/Courses/Views/CreateCourseView.php');
    }

    public function CheckDataValidation(int $id, string $name, int $author, string $content)
    {
        $validation = new ValidationForCourses();

        $idResult = $validation->CheckCourseId($id);
        $nameResult = $validation->CheckCourseName($name);
        $authorResult = $validation->CheckAuthor($author);
        $contentResult = $validation->CheckContent($content);

        if($nameResult && $authorResult && $contentResult){
            return true;
        } else {
            return false;
        }
    }

    public function TryCreateCourse()
    {
        if (isset($_POST['CreateFormCourse']) && isset($_POST['CreateFormAuthor']) && isset($_POST['CreateFormContent'])) {
            if(!$this->CheckDataValidation($_POST['CreateFormCourse'], $_POST['CreateFormAuthor'], $_POST['CreateFormContent'])){
                header("Refresh:0; url=http://localhost/courses/create"); die;
            } else {
                $model = new CourseModel();
                $result = $model->CreateCourse($_POST['CreateFormCourse'], $_POST['CreateFormAuthor'], $_POST['CreateFormContent']);
                if ($result) {
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

    public function ShowEditCourse()
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

    public function TryEditCourse()
    {
        if (isset($_POST['idCourseForEdit']) && isset($_POST['EditFormCourse']) && isset($_POST['EditFormAuthor']) && isset($_POST['EditFormContent'])) {
            if(!$this->CheckDataValidation($_POST['idCourseForEdit'], $_POST['EditFormCourse'], $_POST['EditFormAuthor'], $_POST['EditFormContent'])){
                header("Refresh:0; url=http://localhost/courses/tryedit"); die;
            } else {
                $model = new CourseModel();
                $result = $model->UpdateCourse($_POST['EditFormCourse'], $_POST['EditFormAuthor'], $_POST['EditFormContent'], $_POST['idCourseForEdit']);
                if ($result) {
                    $this->alertMessage("Курс успешно изменён!");
                    header("Refresh:0; url=http://localhost/courses");
                    die;
                } else {
                    $this->alertMessage("Ошибка: Не удалось изменить курс, повторите попытку позже!");
                    header("Refresh:0; url=http://localhost/courses/".$_POST['idCourseForEdit']."/edit");
                    die;
                }
            }
        } else {
            $this->alertMessage("Ошибка: Все поля должны быть заполнены!");
            header("Refresh:0; url=http://localhost/courses/".$_POST['idCourseForEdit']."/edit"); die;
        }
    }
}