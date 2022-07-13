<?php 
session_start();
if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1): ?>

<?php
    require_once('ConnectionValidation.php');
    
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
    <a href="index2.php" class="btn btn-primary">Назад</a>
<div class="divcenter">
      <h2>Изменение пользователя в БД</h2>
      <form name="editrecord" method="post" action="DBEditUser.php">
        <p><b>Id пользователя:</b>
        <input name="iduser" type="text" <?php echo "value=".(int)$_POST['iduser']; ?> readonly>
        </p>
        <p><b>Введите новый логин:</b><br>
        <input name="login" type="text" size="50" <?php echo "value=".$_POST['login'];?> required>
        </p>
        <p><b>Введите новый пароль:</b><br>
        <input name="password" type="password" size="50" required>
        </p>
        <p><b>Введите новый Email:</b><br>
        <input name="email" type="email" size="50" <?php echo "value=".$_POST['email'];?> required>
        </p>
        <p><b>Введите новый телефон (8XXXXXXXXXX):</b><br>
        <input name="phone" type="text" pattern="8[0-9]{10}" size="50" <?php echo "value=".$_POST['phone'];?> required>
        </p>
        <p><b>Выберите новую роль пользователя:</b><br>
        <p>
          <input type="radio" id="contactChoice1" name="role" value="Администратор" 
          <?php 
          if($_POST['role'] == "Администратор"){
            echo "checked";
          }?> required>
          <label for="contactChoice1">Администратор</label>
        </p>
        <p>
          <input type="radio" id="contactChoice2" name="role" value="Клиент" 
          <?php 
          if($_POST['role'] == "Клиент"){
            echo "checked";
          }?>
          <label for="contactChoice2">Клиент</label>
        </p>
        <input type="submit" class="btn btn-outline-warning" value="Изменить пользователя">
        <input type="reset" class="btn btn-info" value="Очистить"></p>
      </form>
      </div>
    <div>
    </body>
</html>

<?php else: ?>
	<p>Пожалуйста, авторизуйтесь!</p>
  <a class="btn btn-primary" href="index.php">Авторизоваться</a>
<?php endif; ?>