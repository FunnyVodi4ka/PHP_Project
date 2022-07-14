<?php
  //Вывод сообщения
  function alertMessage($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
  }

  if(isset($_POST['loginRegister']) && isset($_POST['passwordRegister']) && 
  isset($_POST['emailRegister']) && isset($_POST['phoneRegister'])){
    session_start();
    $_SESSION['customLogin'] = $_POST['loginRegister'];
    $_SESSION['customEmail'] = $_POST['emailRegister'];
    $_SESSION['customPhone'] = $_POST['phoneRegister'];
    require_once('ConnectionValidation.php');

    if($_POST["passwordRegister"] == $_POST["passwordSecondRegister"]){
        $connection = new mysqli("localhost", "root", "Password_12345", "CrudDatabase");
        if($connection->connect_error){
            die("Ошибка: " . $connection->connect_error);
        }
        $id = 0;
        $now_login = $connection->real_escape_string($_POST["loginRegister"]);
        $now_password = $connection->real_escape_string($_POST["passwordRegister"]);
        $now_email = $connection->real_escape_string($_POST["emailRegister"]);
        $now_phone = $connection->real_escape_string($_POST["phoneRegister"]);  

        if(CheckLogin($now_login, $id) && CheckPassword($now_password) && CheckEmail($now_email) 
        && CheckPhone($now_phone)){
            $hashPassword = password_hash($now_password, PASSWORD_DEFAULT);
            $query = "INSERT INTO Users (Login, Password, Email, Phone, IdRole) 
            VALUES ('$now_login', '$hashPassword', '$now_email', '$now_phone', 2)";
            if($connection->query($query)){
                alertMessage("Регистрация прошла успешно!");
                header("Refresh:0; url=index.php");
            } else{
                echo "Ошибка: ".$connection->error;
            }
        }
    }
    else{
        echo "Пароли не совподают, попробуйте снова!";
    }
    unset($_POST['loginRegister']);
    unset($_POST['passwordRegister']);
    unset($_POST['emailRegister']);
    unset($_POST['phoneRegister']);
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Регистрация</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
 </head>
 <body>
    <div class="divcenter">
      <br>
    <h1>Регистрация</h1>
      <form name="register" method="post" action="register.php">
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
        <a href="index.php" class="btn btn-outline-warning">Авторизоваться</a>
        <input type="reset" class="btn btn-outline-danger" value="Очистить">
      </form>
</div>
 </body>
</html>