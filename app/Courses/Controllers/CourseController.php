<?php
require ("../app/Courses/Models/CourseModel.php");
require ("../app/Courses/Views/CourseView.php");

class CourseController
{
    private $model;
    private $view;
    
    public function ShowAllCourses()
    {
        $model = new CourseModel;
        $view = new CourseView;
        $data = $model->getAllCourses();
        $view->printTableCourses($data);
    }
}
$course = new CourseController;
$course->ShowAllCourses();