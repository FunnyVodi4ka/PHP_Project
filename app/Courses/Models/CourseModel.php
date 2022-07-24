<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config/database.php');

class CourseModel
{
    public function SearchCourseId($id)
    {
        $stmt = Connection()->prepare('SELECT * FROM courses WHERE course_id = ?');
        $stmt->execute([$id]);
        $count = $stmt->rowCount();
        return $count;
    }

    public function GetAllCourses(){
        $stmt = Connection()->query('SELECT * FROM courses 
    ORDER BY course_id DESC LIMIT 10;');

        return $stmt;
    }

    public function GetSelectedCourse($courseId)
    {
        $stmt = Connection()->prepare('SELECT course_id, author_id, login, course_name, content, courses.deleted_at FROM courses 
    INNER JOIN users ON courses.author_id = users.user_id WHERE course_id = ?;');
        $stmt->execute([$courseId]);

        return $stmt;
    }

    public function DeleteCourse($courseId)
    {
        $stmt = Connection()->prepare('UPDATE courses SET deleted_at = NOW() WHERE course_id = ?;');
        $stmt->execute([$courseId]);
        return true;
    }

    public function RecoverCourse($courseId)
    {
        $stmt = Connection()->prepare('UPDATE courses SET deleted_at = NULL WHERE course_id = ?;');
        $stmt->execute([$courseId]);
        return true;
    }

    public function SearchAuthor($id)
    {
        $stmt = Connection()->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        $count = $stmt->rowCount();

        return $count;
    }

    public function CreateCourse(string $name, int $idauthor, string $content)
    {
        $stmt = Connection()->prepare("INSERT INTO courses (course_name, author_id, content) 
        VALUES (?, ?, ?)");
        $ContentData = json_encode($content);
        if($stmt->execute([$name, $idauthor, $ContentData])){
            return true;
        } else{
            return false;
        }
    }

    public function UpdateCourse(string $name, int $idauthor, string $content, int $courseId)
    {
        $stmt = Connection()->prepare("UPDATE courses SET course_name = ?, author_id = ?, 
            content = ? WHERE course_id = ?");
        $ContentData = json_encode($content);
        if($stmt->execute([$name, $idauthor, $ContentData, $courseId])){
            return true;
        } else{
            return false;
        }
    }
}