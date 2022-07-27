<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config/database.php');


class UserAccountModel
{
    public function CounterAllCourses()
    {
        $stmt = Connection()->query("SELECT * FROM courses");
        $count = $stmt->rowCount();
        return $count;
    }

    public function CounterMyCourses(int $id)
    {
        $stmt = Connection()->prepare("SELECT * FROM courses WHERE author_id = ?");
        $stmt->execute([$id]);
        $count = $stmt->rowCount();
        return $count;
    }

    public function GetAllCourses(int $list, int $PageCount){
        $stmt = Connection()->query('SELECT * FROM courses 
        ORDER BY course_id DESC LIMIT '.(($list-1)*$PageCount).','.$PageCount.';');

        return $stmt;
    }

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

    public function GetUserCourses(int $id, $list, $PageCount)
    {
        $stmt = Connection()->prepare('SELECT course_id, course_name, login, courses.deleted_at FROM courses
        INNER JOIN users ON courses.author_id = users.user_id 
        WHERE author_id = ? ORDER BY course_id DESC LIMIT '.(($list-1)*$PageCount).','.$PageCount.';');
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

    public function DeleteMyCourse($courseId, $userId)
    {
        $stmt = Connection()->prepare('SELECT * FROM courses WHERE course_id = ? AND author_id = ?;');
        $stmt->execute([$courseId, $userId]);
        if($stmt->rowCount() > 0) {
            $stmt = Connection()->prepare('UPDATE courses SET deleted_at = NOW() WHERE course_id = ? AND author_id = ?;');
            $stmt->execute([$courseId, $userId]);
            return true;
        } else {
            return false;
        }
    }

    public function RecoverMyCourse($courseId, $userId)
    {
        $stmt = Connection()->prepare('SELECT * FROM courses WHERE course_id = ? AND author_id = ?;');
        $stmt->execute([$courseId, $userId]);
        if($stmt->rowCount() > 0) {
            $stmt = Connection()->prepare('UPDATE courses SET deleted_at = NULL WHERE course_id = ? AND author_id = ?;');
            $stmt->execute([$courseId, $userId]);
            return true;
        } else {
            return false;
        }
    }

    public function UpdateMyCourse(string $name, int $courseId, int $authorId)
    {
        $stmt = Connection()->prepare("UPDATE courses SET course_name = ? WHERE course_id = ? AND author_id = ?");
        if($stmt->execute([$name, $courseId, $authorId])){
            return true;
        } else{
            return false;
        }
    }

    public function WorkWithMyElement(string $json, int $id, int $authorId)
    {
        $stmt = Connection()->prepare("UPDATE courses SET content = ? WHERE course_id = ? AND author_id = ?");
        if($stmt->execute([$json, $id, $authorId])){
            return true;
        } else{
            return false;
        }
    }
}