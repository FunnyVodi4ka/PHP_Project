<?php
require_once("/var/www/html/config/ConnectionToDB.php");

class Course{
  public function getAllCourses(){
    $stmt = Connection()->query('SELECT IdCourse, Course, IdAuthor, Content, DeleteAt FROM Courses 
    ORDER BY IdCourse DESC LIMIT 10;');

    return $stmt;
  }
}