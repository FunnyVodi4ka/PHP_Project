<?php
require_once("/var/www/html/config/ConnectionToDB.php");

class CourseModel{
  public function getAllCourses(){
    $stmt = Connection()->query('SELECT IdCourse, Course, IdAuthor, Content, DeleteAt FROM Courses 
    ORDER BY IdCourse DESC LIMIT 15;');
 
    return $stmt;
  }
}