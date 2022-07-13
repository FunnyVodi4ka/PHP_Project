<?php 
session_start();
if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1): ?>

<?php
    require_once('ConnectionValidation.php');
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
 <a href="index2.php" class="btn btn-primary">Назад</a>
<div class="divcenter">
        <h2>Добавление пользователя в БД</h2>
      <form name="register" method="post" action="DBCreateUser.php">
        <p><b>Введите логин:</b><br>
        <input name="login" type="text" size="50" required>
        </p>
        <p><b>Введите пароль:</b><br>
        <input name="password" type="password" size="50" required>
        </p>
        <p><b>Введите Email:</b><br>
        <input name="email" type="email" size="50" required>
        </p>
        <p><b>Введите телефон (8XXXXXXXXXX):</b><br>
        <input name="phone" type="text" pattern="8[0-9]{10}" size="50" required>
        </p>
        <p><b>Выберите роль пользователя:</b><br>
        <p>
          <input type="radio" id="contactChoice1" name="role" value="Администратор" required>
          <label for="contactChoice1">Администратор</label>
        </p>
        <p>
          <input type="radio" id="contactChoice2" name="role" value="Клиент" required>
          <label for="contactChoice2">Клиент</label>
        </p>
        <input type="submit" class="btn btn-outline-success" value="Добавить пользователя">
        <input type="reset" class="btn btn-info" value="Очистить"></p>
      </form>
      </div>
      </body>
</html>

<?php else: ?>
	<p>Пожалуйста, авторизуйтесь!</p>
  <a class="btn btn-primary" href="index.php">Авторизоваться</a>
<?php endif; ?>