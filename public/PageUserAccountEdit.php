<?php 
session_start();
if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 2): ?>

<?php
    require_once('ConnectionValidation.php');

    //Вывод сообщения
  function alertMessage($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
  }

    session_start();
    $userId = $_SESSION["is_userid"];

    $stmt = Connection()->prepare('SELECT Login, Password, Email, Phone FROM Users 
    INNER JOIN Roles ON Users.IdRole = Roles.IdRole WHERE IdUser = ?');
    $stmt->execute([$userId]);
    while ($row = $stmt->fetch())
    {
        $_POST["Login"] = $row["Login"];
        $_POST["Password"] = $row["Password"];
        $_POST["Email"] = $row["Email"];
        $_POST["Phone"] = $row["Phone"];
    }

    if(isset($_POST['loginUserEditer']) && isset($_POST['emailUserEditer']) && 
    isset($_POST['phoneUserEditer'])){
        $_SESSION['customLogin'] = $_POST['loginRegister'];
        $_SESSION['customEmail'] = $_POST['emailRegister'];
        $_SESSION['customPhone'] = $_POST['phoneRegister'];

        require_once('ConnectionValidation.php');
        $connection = new mysqli("localhost", "root", "Password_12345", "CrudDatabase");
        if($connection->connect_error){
            die("Ошибка: " . $connection->connect_error);
        }

        $now_iduser = $userId;
        $now_login = $connection->real_escape_string($_POST["loginUserEditer"]);
        $now_password = $connection->real_escape_string($_POST["passwordUserEditer"]);
        $now_email = $connection->real_escape_string($_POST["emailUserEditer"]);
        $now_phone = $connection->real_escape_string($_POST["phoneUserEditer"]);

        if(empty($now_password)){
            if(CheckIdUser($now_iduser) && CheckLogin($now_login, $now_iduser) && CheckEmail($now_email)
            && CheckPhone($now_phone)){
                $query = "UPDATE Users SET Login = '$now_login', Email = '$now_email', 
                Phone = '$now_phone' WHERE IdUser = $now_iduser";
                if(isset($_FILES['imageUserEditer'])){
                    require_once("imageUpload.php");
                }
                if($uploadOk == 0){
                    echo "Ошибка при обновлении данных!";
                }
                else{
                    if($connection->query($query)){
                        alertMessage("Данные успешно изменены!");
                        $_POST = Array();
                        header("Refresh:0; url=PageUserAccount");
                        die();
                    } 
                    else{
                        echo "Ошибка: " . $connection->error;
                    }
                }
            }
        }
        else{
            if(CheckIdUser($now_iduser) && CheckLogin($now_login, $now_iduser) && CheckPassword($now_password) && CheckEmail($now_email) 
        && CheckPhone($now_phone)){
            $hashPassword = password_hash($now_password, PASSWORD_DEFAULT);
            $query = "UPDATE Users SET Login = '$now_login', Password = '$hashPassword', Email = '$now_email', 
            Phone = '$now_phone' WHERE IdUser = $now_iduser";
            if(isset($_FILES['imageUserEditer'])){
                require_once("imageUpload.php");
            }
            if($uploadOk == 0){
                echo "Ошибка при обновлении данных!";
            }
            else{
                if($connection->query($query)){
                    alertMessage("Данные успешно изменены!");
                    $_POST = Array();
                    header("Refresh:0; url=PageUserAccount");
                    die();
                } 
                else{
                    echo "Ошибка: " . $connection->error;
                }
            }
        }
        }
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD   HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
  <title>CRUD</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
 </head>
 <body>
 <p><a href="PageUserAccount" class="btn btn-primary">Назад</a></p>
<div class="divcenter">
      <h2>Настройки аккаунта</h2>
      <form name="editrecord" method="post" action="PageUserAccountEdit" enctype="multipart/form-data">
        <p><b>Ваш Id:</b>
        <input name="iduserUserEditer" type="text" <?php echo "value=".(int)$_SESSION['is_userid']; ?> readonly>
        </p>
        <p><b>Введите новый логин:</b><br>
        <input name="loginUserEditer" type="text" size="50" value="<?= $_SESSION['customLogin'] ?? $_POST['Login'] ?>" required>
        </p>
        <p><b>Введите новый пароль:</b><br>
        <input name="passwordUserEditer" type="password" size="50">
        </p>
        <p><b>Введите новый Email:</b><br>
        <input name="emailUserEditer" type="email" size="50" value="<?= $_SESSION['customEmail'] ?? $_POST['Email'] ?>" required>
        </p>
        <p><b>Введите новый телефон (8XXXXXXXXXX):</b><br>
        <input name="phoneUserEditer" type="text" pattern="8[0-9]{10}" size="50" value="<?= $_SESSION['customPhone'] ?? $_POST['Phone'] ?>" required>
        </p>
        <p><b>Выберите фотографию профиля:</b><br>
        <input type="file" name="imageUserEditer"></p>
        <input type="submit" class="btn btn-outline-warning" value="Изменить мой аккаунт">
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