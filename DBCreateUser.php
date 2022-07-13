<?php
    require_once('ConnectionValidation.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Результат операции</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
  <meta http-equiv="refresh" content="5;URL=http://localhost/index2.php"/>
 </head>
 <body>
    <p><a href="index2.php" class="btn btn-primary">Назад</a></p>
    <?php
    session_start();
    if($_SESSION["is_role"] == 1 && $_SESSION['is_auth'] == true){
        $connection = new mysqli("localhost", "root", "Password_12345", "CrudDatabase");
        if($connection->connect_error){
            die("Ошибка: " . $connection->connect_error);
        }
        $now_login = $connection->real_escape_string($_POST["login"]);
        $now_password = $connection->real_escape_string($_POST["password"]);
        $now_email = $connection->real_escape_string($_POST["email"]);
        $now_phone = $connection->real_escape_string($_POST["phone"]);
        $now_role = $connection->real_escape_string($_POST["role"]);

        if(CheckLogin($now_login) && CheckPassword($now_password) && CheckEmail($now_email) 
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
    ?>
 </body>
</html>