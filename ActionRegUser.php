<?php
    require_once('ConnectionValidation.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Регистрация</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
  <?php
    function Redirect($status){
        if($status == 1){
            echo '<meta http-equiv="refresh" content="5;URL=http://localhost/index.php"/>';
        }
        else{
            echo '<meta http-equiv="refresh" content="5;URL=http://localhost/reguser.php"/>';
        }
    }
  ?>
 </head>
 <body>
    <?php
    if($_POST["password"] == $_POST["passwordSecond"]){
        $connection = new mysqli("localhost", "root", "Password_12345", "CrudDatabase");
        if($connection->connect_error){
            die("Ошибка: " . $connection->connect_error);
        }
        
        $now_login = $connection->real_escape_string($_POST["login"]);
        $now_password = $connection->real_escape_string($_POST["password"]);
        $now_email = $connection->real_escape_string($_POST["email"]);
        $now_phone = $connection->real_escape_string($_POST["phone"]);  

        if(CheckLogin($now_login) && CheckPassword($now_password) && CheckEmail($now_email) 
        && CheckPhone($now_phone)){
            $hashPassword = password_hash($now_password, PASSWORD_DEFAULT);
            $query = "INSERT INTO Users (Login, Password, Email, Phone, IdRole) 
            VALUES ('$now_login', '$hashPassword', '$now_email', '$now_phone', 2)";
            if($connection->query($query)){
                echo "Регистрация прошла успешно!";
                echo '<p><a href="index.php" class="btn btn-primary">Авторизоваться</a></p>';
                Redirect(1);
            } else{
                echo "Ошибка: ".$connection->error;
                echo '<p><a href="reguser.php" class="btn btn-primary">Зарегистрироваться</a></p>';
                Redirect(2);
            }
        }
    }
    else{
        echo "Пароли не совподают, попробуйте снова!";
        echo '<p><a href="reguser.php" class="btn btn-primary">Зарегистрироваться</a></p>';
        Redirect(2);
    }
    ?>
 </body>
</html>