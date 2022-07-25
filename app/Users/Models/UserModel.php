<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config/database.php');

class UserModel
{
    public function CounterAllUsers()
    {
        $stmt = Connection()->query("SELECT * FROM users");
        $count = $stmt->rowCount();
        return $count;
    }

    public function SearchUserId($id)
    {
        $stmt = Connection()->prepare('SELECT * FROM users WHERE user_id = ?');
        $stmt->execute([$id]);
        $count = $stmt->rowCount();
        return $count;
    }

    public function GetAllUsers(int $list, int $PageCount)
    {
        $stmt = Connection()->query('SELECT user_id, login, password, email, phone, role_name, avatar_image, deleted_at FROM users 
      INNER JOIN roles ON users.role_id = roles.role_id ORDER BY user_id DESC LIMIT '.(($list-1)*$PageCount).','.$PageCount.';');
        return $stmt;
    }

    public function GetSelectedUser($userId)
    {
        $stmt = Connection()->prepare('SELECT user_id, login, email, phone, role_name, avatar_image, deleted_at FROM users 
        INNER JOIN roles ON users.role_id = roles.role_id WHERE user_id = ?');
        $stmt->execute([$userId]);

        return $stmt;
    }

    public function DeleteUser($userId)
    {
        $stmt = Connection()->prepare('UPDATE users SET deleted_at = NOW() WHERE user_id = ?;');
        $stmt->execute([$userId]);
        return true;
    }

    public function RecoverUser($userId)
    {
        $stmt = Connection()->prepare('UPDATE users SET deleted_at = NULL WHERE user_id = ?;');
        $stmt->execute([$userId]);
        return true;
    }

    public function SearchUserLogin($login, $id){
        $stmt = Connection()->prepare('SELECT * FROM users WHERE login = ? AND user_id != ?');
        $stmt->execute([$login, $id]);
        $count = $stmt->rowCount();
        return $count;
    }

    public function CreateUser(string $login, string $password, string $email, string $phone, string $role)
    {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        if($role == "Администратор") {
            $idrole = 1;
        } elseif ($role == "Клиент") {
            $idrole = 2;
        } else {
            return false;
        }
        $stmt = Connection()->prepare("INSERT INTO users (login, password, email, phone, role_id) 
        VALUES (?, ?, ?, ?, ?)");
        if($stmt->execute([$login, $hashPassword, $email, $phone, $idrole])){
            return true;
        } else {
            return false;
        }
    }

    public function UpdateUserWithPassword(string $login, string $password, string $email, string $phone, string $role, string $iduser)
    {
        if ($role == "Администратор") {
            $idrole = 1;
        } elseif ($role == "Клиент") {
            $idrole = 2;
        } else {
            return false;
        }
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = Connection()->prepare("UPDATE users SET login = ?, password = ?, email = ?, 
        phone = ?, role_id = ? WHERE user_id = ?");
        if ($stmt->execute([$login, $hashPassword, $email, $phone, $idrole, $iduser])) {
            return true;
        } else {
            return false;
        }
    }

    public function UpdateUserWithoutPassword(string $login, string $email, string $phone, string $role, int $iduser)
    {
        if($role == "Администратор") {
            $idrole = 1;
        } elseif ($role == "Клиент") {
            $idrole = 2;
        } else {
            return false;
        }
        $stmt = Connection()->prepare("UPDATE users SET login = ?, email = ?, 
        phone = ?, role_id = ? WHERE user_id = ?");
        if($stmt->execute([$login, $email, $phone, $idrole, $iduser])){
            return true;
        } else {
            return false;
        }
    }
}