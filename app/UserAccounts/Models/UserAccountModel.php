<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config/database.php');


class UserAccountModel
{
    public function CounterAllUsers()
    {
        $stmt = Connection()->query("SELECT * FROM users");
        $count = $stmt->rowCount();
        return $count;
    }

    public function GetUserData(int $id)
    {
        $stmt = Connection()->prepare('SELECT login, email, phone, role_name, avatar_image FROM users
        INNER JOIN roles ON users.role_id = roles.role_id WHERE user_id = ?');
        $stmt->execute([$id]);

        return $stmt;
    }

    public function GetAllUsers($list, $PageCount)
    {
        $stmt = Connection()->query('SELECT * FROM users 
        INNER JOIN roles ON users.role_id = roles.role_id 
        WHERE deleted_at IS NULL ORDER BY user_id DESC LIMIT '.(($list-1)*$PageCount).','.$PageCount.';');

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

    public function UpdateUserWithPassword(string $login, string $password, string $email, string $phone, string $iduser)
    {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = Connection()->prepare("UPDATE users SET login = ?, password = ?, email = ?, 
        phone = ? WHERE user_id = ?");
        if ($stmt->execute([$login, $hashPassword, $email, $phone, $iduser])) {
            return true;
        } else {
            return false;
        }
    }

    public function UpdateUserWithoutPassword(string $login, string $email, string $phone, int $iduser)
    {
        $stmt = Connection()->prepare("UPDATE users SET login = ?, email = ?, 
        phone = ? WHERE user_id = ?");
        if($stmt->execute([$login, $email, $phone, $iduser])){
            return true;
        } else {
            return false;
        }
    }
}