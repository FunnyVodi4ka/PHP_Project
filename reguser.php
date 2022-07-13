<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Регистрация</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
 </head>
 <body>
    <div class="divcenter">
      <br>
    <h1>Регистрация</h1>
      <form name="register" method="post" action="ActionRegUser.php">
        <p><b>Введите логин:</b><br>
        <input name="login" type="text" size="50" required>
        </p>
        <p><b>Введите пароль:</b><br>
        <input name="password" type="password" size="50" required>
        </p>
        <p><b>Повторите пароль:</b><br>
        <input name="passwordSecond" type="password" size="50" required>
        </p>
        <p><b>Введите Email:</b><br>
        <input name="email" type="email" size="50" required>
        </p>
        <p><b>Введите телефон (8XXXXXXXXXX):</b><br>
        <input name="phone" type="text" pattern="8[0-9]{10}" size="50" required>
        </p>
        <input type="submit" class="btn btn-outline-success" value="Создать аккаунт">
        <a href="index.php" class="btn btn-outline-warning">Авторизоваться</a>
        <input type="reset" class="btn btn-outline-danger" value="Очистить">
      </form>
</div>
 </body>
</html>