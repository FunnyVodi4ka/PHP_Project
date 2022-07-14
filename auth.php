<?php
  session_start();
  if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1){
    header("Refresh:0; url=index.php");
  }
  elseif($_SESSION["is_auth"] && $_SESSION["is_role"] == 2){
    header("Refresh:0; url=PageUserAccount.php");
  }

  require_once('ConnectionValidation.php');

  if(isset($_POST['loginEnter']) && isset($_POST['passwordEnter'])){
    session_start();
	  unset($_SESSION['is_auth']);
    unset($_SESSION['is_userid']);
    unset($_SESSION['is_role']);
    $_SESSION = array();

    $now_login = $_POST["loginEnter"];
    $now_password = $_POST["passwordEnter"];
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
                    header("Refresh:0; url=index.php");
                }
                elseif($row["IdRole"] == 2){
                    $_SESSION["is_auth"] = true;
                    $_SESSION["is_userid"] = $row["IdUser"];
                    $_SESSION["is_role"] = 2;
                    header("Refresh:0; url=PageUserAccount.php");
                }
                else{
                    echo 'Ошибка доступа, обратитесь к администратору!';
                }
            }
            else {
                echo 'Ошибка авторизации, неправильный логин или пароль!';
            }
        }
    }
    else{
        echo 'Ошибка авторизации, неправильный логин или пароль!';
    }
    unset($_POST['loginEnter']);
    unset($_POST['passwordEnter']);
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Авторизация</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
 </head>
 <body>
 <br>
  <h1>Авторизация</h1>
  <div class="divcenter">
    <form name="register" method="post" action="auth.php">
        <p><b>Введите логин:</b><br>
        <input name="loginEnter" type="text" size="40" required>
        </p>
        <p><b>Введите пароль:</b><br>
        <input name="passwordEnter" type="password" size="40" required>
        </p>
        <input type="submit" class="btn btn-outline-success" value="Войти">
        <a href="register.php" class="btn btn-outline-warning">Регистрация</a>
        <input type="reset" class="btn btn-outline-danger" value="Очистить">
      </form>
    </div>
    <h2>Список пользователей</h2>
    <div class="divcenter">
    <a class="btn btn-primary" href="users.php">Просмотреть список пользователей</a>
    </div>
 </body>
</html>