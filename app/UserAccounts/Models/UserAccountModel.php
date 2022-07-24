<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config/database.php');


class UserAccountModel
{
    public function GetUserData(int $id)
    {
        $stmt = Connection()->prepare('SELECT login, email, phone, role_name, avatar_image FROM users
        INNER JOIN roles ON users.role_id = roles.role_id WHERE user_id = ?');
        $stmt->execute([$id]);

        return $stmt;
    }

    public function GetAllUsers()
    {
        $stmt = Connection()->query('SELECT * FROM users 
        INNER JOIN roles ON users.role_id = roles.role_id 
        WHERE deleted_at IS NULL ORDER BY user_id DESC LIMIT 10');

        return $stmt;
    }

    public function GetUserCourses(int $id)
    {
        $stmt = Connection()->prepare('SELECT course_id, course_name, login FROM courses
        INNER JOIN users ON courses.author_id = users.user_id 
        WHERE user_id = ? AND courses.deleted_at IS NULL ORDER BY course_id DESC LIMIT 10;');
        $stmt->execute([$id]);

        return $stmt;
    }

    public function GetSelectedCourse($courseId)
    {
        $stmt = Connection()->prepare('SELECT course_id, login, course_name, content, courses.deleted_at FROM courses 
    INNER JOIN users ON courses.author_id = users.user_id WHERE course_id = ?;');
        $stmt->execute([$courseId]);

        return $stmt;
    }
}