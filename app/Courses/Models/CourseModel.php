<?php
require_once("/var/www/html/config/ConnectionToDB.php");

class CourseModel
{
  public function getAllCourses(){
    $stmt = Connection()->query('SELECT * FROM Courses 
    ORDER BY IdCourse DESC LIMIT 10;');
 
    return $stmt;
  }

  public function getSelectedCourse($courseId)
  {
    $stmt = Connection()->prepare('SELECT * FROM Courses 
    INNER JOIN Users ON Courses.IdAuthor = Users.IdUser WHERE IdCourse = ?;');
    $stmt->execute([$courseId]);
    
    return $stmt;
  }

  public function DeleteCourse($courseId)
  {
    $stmt = Connection()->prepare('UPDATE Courses SET DeleteAt = NOW() WHERE IdCourse = ?;');
    $stmt->execute([$courseId]);
  }

  public function RecoverCourse($courseId)
  {
    $stmt = Connection()->prepare('UPDATE Courses SET DeleteAt = NULL WHERE IdCourse = ?;');
    $stmt->execute([$courseId]);
  }
}