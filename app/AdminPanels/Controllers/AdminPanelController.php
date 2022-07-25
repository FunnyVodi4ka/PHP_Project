<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config/links.php');

class AdminPanelController
{
    public function __construct()
    {
        $this->CheckSession();
    }

    public function CheckSession()
    {
        session_start();
        if (!$_SESSION["is_auth"] && $_SESSION["is_role"] != 1) {
            header("Refresh:0; url=http://localhost/auth"); die;
        }
    }

    public function CheckAuthorization()
    {
        session_start();
        if($_SESSION["is_auth"] && $_SESSION["is_role"] == 1){
            return true;
        } else {
            return false;
        }
    }

    public function ShowAdminPanel()
    {
        if($this->CheckAuthorization()) {
            require $_SERVER['DOCUMENT_ROOT'] . '/app/AdminPanels/Views/AdminPanelView.php';
        } else {
            header("Refresh:0; url=auth");
            die;
        }
    }
}