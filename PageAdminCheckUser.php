<?php 
session_start();
if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1): 
?>
<?php
    require_once('ConnectionValidation.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Аккаунт клиента</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
 </head>
 <body>
    <b><a href="index2.php" class="btn btn-primary">Назад</a></b>
    <?php
        session_start();
        $userId = $_POST["idUserForCheck"];
        echo "<h2>Аккаунт клиента с Id:".$userId."</h2>";

        $stmt = Connection()->prepare('SELECT Login, Email, Phone, Role FROM Users 
        INNER JOIN Roles ON Users.IdRole = Roles.IdRole WHERE IdUser = ?');
        $stmt->execute([$userId]);
        while ($row = $stmt->fetch())
        {
        echo "<p><b>Логин пользователя:</b> ".$row["Login"]."</p>";
        echo "<p><b>Почта пользователя:</b> ".$row["Email"]."</p>";
        echo "<p><b>Телефон пользователя:</b> ".$row["Phone"]."</p>";
        echo "<p><b>Роль пользователя:</b> ".$row["Role"]."</p>";
        echo "<p><b>Фотография пользователя:</b> "."</p>";
        }
    ?>
</body>
</html>
<?php else: ?>
<p>Ошибка доступа, авторизуйтесь!</p>
<a class="btn btn-primary" href="index.php">Авторизоваться</a>
<?php endif; ?>