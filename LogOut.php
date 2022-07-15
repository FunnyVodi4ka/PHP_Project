<?php
  session_start();
  $_SESSION = [];
  unset($_SESSION['is_auth']);
  unset($_SESSION['is_userid']);
  unset($_SESSION['is_role']);
  session_destroy();

  header("Refresh:0; url=auth");
?>