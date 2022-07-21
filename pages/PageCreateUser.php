<?php 
session_start();
if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1): ?>

<?php
  unset($_SESSION['customLogin']);
  unset($_SESSION['customEmail']);
  unset($_SESSION['customPhone']);
  if(isset($_POST['loginCreater']) && isset($_POST['passwordCreater']) && 
  isset($_POST['emailCreater']) && isset($_POST['phoneCreater']) && isset($_POST['roleCreater'])){
    $_SESSION['customLogin'] = $_POST['loginCreater'];
    $_SESSION['customEmail'] = $_POST['emailCreater'];
    $_SESSION['customPhone'] = $_POST['phoneCreater'];
    require_once('../config/ConnectionToDB.php');
    require_once('../assets/ValidationForUsers.php');
    #session_start();
    if($_SESSION["is_role"] == 1 && $_SESSION['is_auth'] == true){
        $id = 0;
        $now_login = $_POST["loginCreater"];
        $now_password = $_POST["passwordCreater"];
        $now_email = $_POST["emailCreater"];
        $now_phone = $_POST["phoneCreater"];
        $now_role = $_POST["roleCreater"];

        if(CheckLogin($now_login, $id) && CheckPassword($now_password) && CheckEmail($now_email) 
        && CheckPhone($now_phone) && CheckRole($now_role)){
          if($now_role == "Администратор"){
              $code_role = 1;
          }
          elseif($now_role == "Клиент"){
            $code_role = 2;
          }
          $hashPassword = password_hash($now_password, PASSWORD_DEFAULT);
          $stmt = Connection()->prepare("INSERT INTO Users (Login, Password, Email, Phone, IdRole) 
          VALUES (?, ?, ?, ?, ?)");
          if($stmt->execute([$now_login, $hashPassword, $now_email, $now_phone, $code_role])){
            unset($_SESSION['customLogin']);
            unset($_SESSION['customEmail']);
            unset($_SESSION['customPhone']);
            echo "Данные успешно добавлены!";
          } else{
              echo "Ошибка: Повторите попытку позже!";
          }
        }
      }
    }
    else{
        echo "Ошибка доступа, повторите попытку позже!";
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>CRUD</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/style.css">
 </head>
 <body>
  <p><a href="http://localhost/PageTableUsers" class="btn btn-primary">Назад</a></p>
<div class="divcenter">
        <h2>Добавление пользователя в БД</h2>
      <form name="register" method="post" action="PageCreateUser">
        <p><b>Введите логин:</b><br>
        <input name="loginCreater" type="text" size="50" value="<?= $_SESSION['customLogin'] ?? '' ?>" required>
        </p>
        <p><b>Введите пароль:</b><br>
        <input name="passwordCreater" type="password" size="50" required>
        </p>
        <p><b>Введите Email:</b><br>
        <input name="emailCreater" type="email" size="50" value="<?= $_SESSION['customEmail'] ?? '' ?>" required>
        </p>
        <p><b>Введите телефон (8XXXXXXXXXX):</b><br>
        <input name="phoneCreater" type="text" pattern="8[0-9]{10}" size="50" value="<?= $_SESSION['customPhone'] ?? '' ?>" required>
        </p>
        <p><b>Выберите роль пользователя:</b><br>
        <p>
          <input type="radio" id="contactChoice1" name="roleCreater" value="Администратор" required>
          <label for="contactChoice1">Администратор</label>
        </p>
        <p>
          <input type="radio" id="contactChoice2" name="roleCreater" value="Клиент" required>
          <label for="contactChoice2">Клиент</label>
        </p>
        <input type="submit" class="btn btn-outline-success" value="Добавить пользователя">
        <input type="reset" class="btn btn-info" value="Очистить"></p>
      </form>
      </div>
      </body>
</html>

<?php else: 
    header("Refresh:0; url=auth");
    die();
endif; ?>