<?php
  session_start();
  $_SESSION = [];
  unset($_SESSION['is_auth']);
  unset($_SESSION['is_userid']);
  unset($_SESSION['is_role']);
  session_destroy();

  #echo __DIR__.'auth.php';
  header("Refresh:0; url=auth");
?>