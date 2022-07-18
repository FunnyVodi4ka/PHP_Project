<?php 
session_start();
if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1): ?>

<?php
  if(isset($_POST['loginCreater']) && isset($_POST['passwordCreater']) && 
  isset($_POST['emailCreater']) && isset($_POST['phoneCreater']) && isset($_POST['roleCreater'])){
    $_SESSION['customLogin'] = $_POST['loginRegister'];
    $_SESSION['customEmail'] = $_POST['emailRegister'];
    $_SESSION['customPhone'] = $_POST['phoneRegister'];
    require_once('ConnectionValidation.php');
    #session_start();
    if($_SESSION["is_role"] == 1 && $_SESSION['is_auth'] == true){
        $connection = new mysqli("localhost", "root", "Password_12345", "CrudDatabase");
        if($connection->connect_error){
            die("Ошибка: " . $connection->connect_error);
        }
        $id = 0;
        $now_login = $connection->real_escape_string($_POST["loginCreater"]);
        $now_password = $connection->real_escape_string($_POST["passwordCreater"]);
        $now_email = $connection->real_escape_string($_POST["emailCreater"]);
        $now_phone = $connection->real_escape_string($_POST["phoneCreater"]);
        $now_role = $connection->real_escape_string($_POST["roleCreater"]);

        if(CheckLogin($now_login, $id) && CheckPassword($now_password) && CheckEmail($now_email) 
        && CheckPhone($now_phone) && CheckRole($now_role)){
            $query = "SELECT * FROM Users WHERE Login = '$now_login'";
            $result = mysqli_query($connection, $query);

            if($result = $connection->query($query)){
                $rowsCount = $result->num_rows;
                if($rowsCount > 0){
                    echo 'Пользователь с таким логином уже существует!';
                }
                else{
                    if($now_role == "Администратор"){}
                        $code_role = 1;
                    $hashPassword = password_hash($now_password, PASSWORD_DEFAULT);
                    $query = "INSERT INTO Users (Login, Password, Email, Phone, IdRole) 
                    VALUES ('$now_login', '$hashPassword', '$now_email', '$now_phone', $code_role)";
                    if($connection->query($query)){
                        echo "Данные успешно добавлены!";
                    } else{
                        echo "Ошибка: " . $connection->error;
                    }
                }
            }
        }
    }
    else{
        echo "Ошибка доступа, повторите попытку позже!";
    }
    unset($_POST['loginCreater']);
    unset($_POST['passwordCreater']);
    unset($_POST['emailCreater']);
    unset($_POST['phoneCreater']);
    unset($_POST['roleCreater']);
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>CRUD</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
 </head>
 <body>
  <p><a href="/" class="btn btn-primary">Назад</a></p>
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