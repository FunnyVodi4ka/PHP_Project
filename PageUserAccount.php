<?php 
session_start();
if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 2): ?>
<?php
    require_once('ConnectionValidation.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Ваш аккаунт</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
 </head>
 <body>
    <p><a href="LogOut.php" class="btn btn-primary" onclick="return  confirm('Вы точно хотите выйти?')">Выход</a></p>
    <h2>Ваши данные:</h2>
    <?php
        session_start();
        $userId = $_SESSION["is_userid"];

        $stmt = Connection()->prepare('SELECT Login, Email, Phone, Role FROM Users 
        INNER JOIN Roles ON Users.IdRole = Roles.IdRole WHERE IdUser = ?');
        $stmt->execute([$userId]);
        while ($row = $stmt->fetch())
        {
        echo "<p><b>Ваш логин:</b> ".$row["Login"]."</p>";
        echo "<p><b>Ваша почта:</b> ".$row["Email"]."</p>";
        echo "<p><b>Ваш телефон:</b> ".$row["Phone"]."</p>";
        echo "<p><b>Ваша роль:</b> ".$row["Role"]."</p>";
        echo "<p><b>Ваша фотография:</b> "."</p>"; //добавить фотографию
        }
    ?>
 </body>
</html>

<?php else: ?>
	<p>Пожалуйста, авторизуйтесь!</p>
  <a class="btn btn-primary" href="index.php">Авторизоваться</a>
<?php endif; ?>