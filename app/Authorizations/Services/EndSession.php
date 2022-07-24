<?php
class EndSession
{
    public function ServiceEndSession()
    {
        session_start();
        $_SESSION = NULL;
        session_destroy();
        header("Refresh:0; url=auth");
        die;
    }
}