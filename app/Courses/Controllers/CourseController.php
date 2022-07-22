<?php
require ("../app/Courses/Models/CourseModel.php");

class CourseController
{
    public function getIdFromURL(){
        $uri = $_SERVER['REQUEST_URI'];
        $parseUri = explode('/', $uri);
        if(count($parseUri) == 4) { //строгое сравнение
            return (int)$parseUri[2];
        }
        //return
        //name метод
    }

    public function ShowAllCourses()
    {
        require ("../app/Courses/Views/CourseView.php");
        $model = new CourseModel;
        $view = new CourseView;
        $data = $model->getAllCourses();
        $view->printTableCourses($data);
    }

    public function ShowSelectedCourse()
    {
        $model = new CourseModel;
        $contoller = new CourseController;
        $courseId = $contoller->getIdFromURL();
        $stmt = $model->getSelectedCourse($courseId);
        require ("../app/Courses/Views/SelectedCourseView.php");
    }

    public function DeleteCourse()
    {
        require ("../app/Courses/Views/CourseView.php");
        $model = new CourseModel;
        $contoller = new CourseController;
        $view = new CourseView;
        $courseId = $contoller->getIdFromURL();
        $model->DeleteCourse($courseId);

        $data = $model->getAllCourses();
        $view->printTableCourses($data);
    }

    public function RecoverCourse()
    {
        require ("../app/Courses/Views/CourseView.php");
        $model = new CourseModel;
        $contoller = new CourseController;
        $view = new CourseView;
        $courseId = $contoller->getIdFromURL();
        $model->RecoverCourse($courseId);

        $data = $model->getAllCourses();
        $view->printTableCourses($data);
    }
}