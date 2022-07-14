<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>CRUD</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
  <?php
    function LogOut(){
        echo '<meta http-equiv="refresh" content="0;URL=http://localhost/auth.php"/>';
    }
  ?>
 </head>
 <body>
    <?php
        session_start();
        $_SESSION = array();
	      unset($_SESSION['is_auth']);
        unset($_SESSION['is_userid']);
        unset($_SESSION['is_role']);
        session_destroy();

        LogOut();
    ?>
 </body>
</html>