<?php
class StartSession
{
    public function ServiceStartSession(bool $status, int $id, int $role){
        session_start();
        $_SESSION["is_auth"] = $status;
        $_SESSION["is_userid"] = $id;
        $_SESSION["is_role"] = $role;
    }
}