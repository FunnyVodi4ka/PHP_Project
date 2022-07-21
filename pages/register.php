<?php
  session_start();
  if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1){
    header("Refresh:0; url=/");
    die();
  }
  elseif($_SESSION["is_auth"] && $_SESSION["is_role"] == 2){
    header("Refresh:0; url=PageUserAccount");
    die();
  }

  //Вывод сообщения
  function alertMessage($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
  }
  unset($_SESSION['customLogin']);
  unset($_SESSION['customEmail']);
  unset($_SESSION['customPhone']);
  if(isset($_POST['loginRegister']) && isset($_POST['passwordRegister']) && 
  isset($_POST['emailRegister']) && isset($_POST['phoneRegister'])){
    session_start();
    $_SESSION['customLogin'] = $_POST['loginRegister'];
    $_SESSION['customEmail'] = $_POST['emailRegister'];
    $_SESSION['customPhone'] = $_POST['phoneRegister'];
    require_once('../config/ConnectionToDB.php');
    require_once('../assets/ValidationForUsers.php');

    if($_POST["passwordRegister"] == $_POST["passwordSecondRegister"]){
        $id = 0;
        $now_login = $_POST["loginRegister"];
        $now_password = $_POST["passwordRegister"];
        $now_email = $_POST["emailRegister"];
        $now_phone = $_POST["phoneRegister"];  
        $standardIdRole = 2;

        if(CheckLogin($now_login, $id) && CheckPassword($now_password) && CheckEmail($now_email) 
        && CheckPhone($now_phone)){
            $hashPassword = password_hash($now_password, PASSWORD_DEFAULT);
            $stmt = Connection()->prepare("INSERT INTO Users (Login, Password, Email, Phone, IdRole) 
            VALUES (?, ?, ?, ?, ?)");
            if($stmt->execute([$now_login, $hashPassword, $now_email, $now_phone, $standardIdRole])){
              $_POST = [];
                alertMessage("Регистрация прошла успешно!");
                header("Refresh:0; url=auth");
                die();
            } else{
                echo "Ошибка: Повторите попытку позже!";
            }
        }
    }
    else{
        echo "Пароли не совподают, попробуйте снова!";
    }
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Регистрация</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/style.css">
 </head>
 <body>
    <div class="divcenter">
      <br>
    <h1>Регистрация</h1>
      <form name="register" method="post" action="register">
        <p><b>Введите логин:</b><br>
        <input name="loginRegister" type="text" size="50" value="<?= $_SESSION['customLogin'] ?? '' ?>" required>
        </p>
        <p><b>Введите пароль:</b><br>
        <input name="passwordRegister" type="password" size="50" required>
        </p>
        <p><b>Повторите пароль:</b><br>
        <input name="passwordSecondRegister" type="password" size="50" required>
        </p>
        <p><b>Введите Email:</b><br>
        <input name="emailRegister" type="email" size="50" value="<?= $_SESSION['customEmail'] ?? '' ?>" required>
        </p>
        <p><b>Введите телефон (8XXXXXXXXXX):</b><br>
        <input name="phoneRegister" type="text" pattern="8[0-9]{10}" size="50" value="<?= $_SESSION['customPhone'] ?? '' ?>" required>
        </p>
        <input type="submit" class="btn btn-outline-success" value="Создать аккаунт">
        <a href="auth" class="btn btn-outline-warning">Авторизоваться</a>
        <input type="reset" class="btn btn-outline-danger" value="Очистить">
      </form>
</div>
 </body>
</html>