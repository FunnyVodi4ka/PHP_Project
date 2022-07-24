<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Авторизация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<h1>Авторизация</h1>
<div class="divcenter">
    <form method="post" action="http://localhost/tryauth">
        <p><b>Введите логин:</b><br>
            <input name="loginEnter" type="text" size="35" required>
        </p>
        <p><b>Введите пароль:</b><br>
            <input name="passwordEnter" type="password" size="35" required>
        </p>
        <input type="submit" class="btn btn-outline-success" value="Войти">
        <a href="http://localhost/register" class="btn btn-outline-warning">Регистрация</a>
        <input type="reset" class="btn btn-outline-danger" value="Очистить">
    </form>
</div>
<!--
<h2>Список пользователей</h2>
<div class="divcenter">
    <a class="btn btn-primary" href="http://localhost/users">Просмотреть список пользователей</a>
</div>
-->
</body>
</html>