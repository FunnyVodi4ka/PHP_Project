<?php 
session_start();
if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1 && !empty($_POST['iduser'])): ?>

<?php
  unset($_SESSION['customLogin']);
  unset($_SESSION['customEmail']);
  unset($_SESSION['customPhone']);
  require_once('../config/ConnectionToDB.php');
  $stmt = Connection()->prepare('SELECT * FROM Users 
  INNER JOIN Roles ON Users.IdRole = Roles.IdRole 
  WHERE IdUser = ? AND DeleteAt IS NULL');
  $stmt->execute([$_POST['iduser']]);
  while ($row = $stmt->fetch())
  {
    $_POST['login'] = $row['Login'];
    $_POST['email'] = $row['Email'];
    $_POST['phone'] = $row['Phone'];
    $_POST['role'] = $row['Role'];
  }
 
  //Вывод сообщения
  function alertMessage($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
  }

  if(isset($_POST['loginEditer']) && isset($_POST['passwordEditer']) && 
  isset($_POST['emailEditer']) && isset($_POST['phoneEditer']) && isset($_POST['roleEditer'])){
    $_SESSION['customLogin'] = $_POST['loginEditer'];
    $_SESSION['customEmail'] = $_POST['emailEditer'];
    $_SESSION['customPhone'] = $_POST['phoneEditer'];
    require_once('../assets/ValidationForUsers.php');
    if($_SESSION["is_role"] == 1 && $_SESSION['is_auth'] == true){
        $connection = new mysqli("localhost", "root", "Password_12345", "CrudDatabase");
        if($connection->connect_error){
            die("Ошибка: " . $connection->connect_error);
        }
        
        $now_iduser = (int)$_POST['iduser'];
        $now_login = $connection->real_escape_string($_POST["loginEditer"]);
        $now_password = $connection->real_escape_string($_POST["passwordEditer"]);
        $now_email = $connection->real_escape_string($_POST["emailEditer"]);
        $now_phone = $connection->real_escape_string($_POST["phoneEditer"]);
        $now_role = $connection->real_escape_string($_POST["roleEditer"]);    
        
        if(empty($now_password)){
          if(CheckIdUser($now_iduser) && CheckLogin($now_login, $now_iduser) && CheckEmail($now_email) 
          && CheckPhone($now_phone) && CheckRole($now_role)){
              if($now_role == "Администратор")
                  $code_role = 1;
              else
                  $code_role = 2;
              $hashPassword = password_hash($now_password, PASSWORD_DEFAULT);
              if($_POST['iduser'] == $_SESSION['is_userid']){
                $code_role = 1;
              }
              $query = "UPDATE Users SET Login = '$now_login', Email = '$now_email', 
              Phone = '$now_phone', IdRole = $code_role WHERE IdUser = $now_iduser";
              if($connection->query($query)){
                  alertMessage("Данные успешно изменены!");
                  $_POST = Array();
                  header("Refresh:0; url=PageTableUsers");
                  die();
              } else{
                  echo "Ошибка: " . $connection->error;
              }
          }
        }
        else{
          if(CheckIdUser($now_iduser) && CheckLogin($now_login, $now_iduser) && CheckPassword($now_password) && CheckEmail($now_email) 
          && CheckPhone($now_phone) && CheckRole($now_role)){
              if($now_role == "Администратор")
                  $code_role = 1;
              else
                  $code_role = 2;
              $hashPassword = password_hash($now_password, PASSWORD_DEFAULT);
              if($_POST['iduser'] == $_SESSION['is_userid']){
                $code_role = 1;
              }
              $query = "UPDATE Users SET Login = '$now_login', Password = '$hashPassword', Email = '$now_email', 
              Phone = '$now_phone', IdRole = $code_role WHERE IdUser = $now_iduser";
              if($connection->query($query)){
                  alertMessage("Данные успешно изменены!");
                  $_POST = [];
                  unset($_SESSION['customLogin']);
                  unset($_SESSION['customEmail']);
                  unset($_SESSION['customPhone']);
                  header("Refresh:0; url=PageTableUsers");
                  die();
              } else{
                  echo "Ошибка: " . $connection->error;
              }
          }
        }
    }
    else{
        echo "Ошибка доступа, повторите попытку позже!";
    }
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD   HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
  <title>CRUD</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
 </head>
 <body>
    <p><a href="PageTableUsers" class="btn btn-primary">Назад</a></p>
<div class="divcenter">
      <h2>Изменение пользователя в БД</h2>
      <form name="editrecord" method="post" action="PageEditUser">
        <p><b>Id пользователя:</b>
        <input name="iduser" type="text" <?php echo "value=".(int)$_POST['iduser']; ?> readonly>
        </p>
        <p><b>Введите новый логин:</b><br>
        <input name="loginEditer" type="text" size="50" value="<?= $_SESSION['customLogin'] ?? $_POST['login']?>" required>
        </p>
        <p><b>Введите новый пароль:</b><br>
        <input name="passwordEditer" type="password" size="50">
        </p>
        <p><b>Введите новый Email:</b><br>
        <input name="emailEditer" type="email" size="50" value="<?= $_SESSION['customEmail'] ?? $_POST['email']?>" required>
        </p>
        <p><b>Введите новый телефон (8XXXXXXXXXX):</b><br>
        <input name="phoneEditer" type="text" pattern="8[0-9]{10}" size="50" value="<?= $_SESSION['customPhone'] ?? $_POST['phone']?>" required>
        </p>
        <p><b>Выберите новую роль пользователя:</b><br>
        <p>
          <input type="radio" id="contactChoice1" name="roleEditer" value="Администратор" 
          <?php 
          if($_POST['role'] == "Администратор"){
            echo "checked";
          }?> required <?php if($_POST['iduser'] == $_SESSION['is_userid']) echo "disabled"; ?>>
          <label for="contactChoice1">Администратор</label>
        </p>
        <p>
          <input type="radio" id="contactChoice2" name="roleEditer" value="Клиент" 
          <?php 
          if($_POST['role'] == "Клиент"){
            echo "checked";
          }?> required <?php if($_POST['iduser'] == $_SESSION['is_userid']) echo "disabled"; ?>>
          <label for="contactChoice2">Клиент</label>
        </p>
        <input type="submit" class="btn btn-outline-warning" value="Изменить пользователя">
        <input type="reset" class="btn btn-info" value="Очистить"></p>
      </form>
      </div>
    <div>
    </body>
</html>

<?php else: 
    header("Refresh:0; url=auth");
    die();
endif; ?>