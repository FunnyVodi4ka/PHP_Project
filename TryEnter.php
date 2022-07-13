<?php
    require_once('ConnectionValidation.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Авторизации</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
  <?php
    function Redirect($role){
        if($role == 1){
            echo '<meta http-equiv="refresh" content="0;URL=http://localhost/index2.php"/>';
        }
        elseif($role == 2){
            echo '<meta http-equiv="refresh" content="0;URL=http://localhost/PageUserAccount.php"/>';
        }
        else{
            echo '<meta http-equiv="refresh" content="2;URL=http://localhost/index.php"/>';
        }
    }
  ?>
 </head>
 <body>
 <?php
    session_start();
	unset($_SESSION['is_auth']);
    unset($_SESSION['is_userid']);
    unset($_SESSION['is_role']);
    $_SESSION = array();

    $now_login = $_POST["enter_login"];
    $now_password = $_POST["enter_password"];
    $stmt = Connection()->prepare('SELECT * FROM Users WHERE Login = ? AND DeleteAt IS NULL');
    $stmt->execute([$now_login]);
    if(count($stmt->fetchAll()) == 1){
        $stmt->execute([$now_login]);
        while ($row = $stmt->fetch())
        {
            if (password_verify($now_password, $row["Password"])) {
                echo 'Вы авторизовались, поздравляю!';
                if($row["IdRole"] == 1){
                    $_SESSION["is_auth"] = true;
                    $_SESSION["is_userid"] = $row["IdUser"];
                    $_SESSION["is_role"] = 1;
                    Redirect(1);
                }
                elseif($row["IdRole"] == 2){
                    $_SESSION["is_auth"] = true;
                    $_SESSION["is_userid"] = $row["IdUser"];
                    $_SESSION["is_role"] = 2;
                    Redirect(2);
                }
                else{
                    echo 'Ошибка доступа, обратитесь к администратору!';
                    Redirect(3);
                }
            }
            else {
                echo 'Ошибка авторизации, неправильный логин или пароль!';
                Redirect(3);
            }
        }
    }
    else{
        echo 'Ошибка авторизации, неправильный логин или пароль!';
        Redirect(3);
    }
    ?>
 </body>
</html>