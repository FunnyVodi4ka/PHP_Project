<?php
require ("/var/www/html/app/Courses/Models/CourseModel.php");
require ("/var/www/html/app/Courses/Views/CourseView.php");
class CourseControl{
    public function ShowAllCourses(){
        $model = new Course;
        $data = $model->getAllCourses();
        $view = new CourseView;
        $view->printTableCourses($data);
    }
}
$course = new CourseControl;
$course->ShowAllCourses();