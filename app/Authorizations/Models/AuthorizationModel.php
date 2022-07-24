<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Authorizations/Services/StartSession.php');


class AuthorizationModel
{
    public function CheckUser($enterLogin, $enterPassword)
    {
        $stmt = Connection()->prepare('SELECT * FROM users WHERE login = ? AND deleted_at IS NULL;');
        $stmt->execute([$enterLogin]);
        $rowCounter = $stmt->rowCount();
        if($rowCounter == 1){
            while ($row = $stmt->fetch())
            {
                if (password_verify($enterPassword, $row["password"])) {
                    if($row["role_id"] == 1){
                        $start = new StartSession();
                        $start->ServiceStartSession(true, $row["user_id"], 1);//
                        return "admin";
                    } elseif($row["role_id"] == 2) {
                        $start = new StartSession();
                        $start->ServiceStartSession(true, $row["user_id"], 2);//
                        return "user";
                    } else {
                        return "noname";
                    }
                } else{
                    return "noname";
                }
            }
        } else {
            return "noname";
        }
    }
}