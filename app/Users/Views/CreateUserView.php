<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Create User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<p><a href="http://localhost/users" class="btn btn-primary">Назад</a></p>
<div class="divcenter">
    <h2>Добавление пользователя в БД</h2>
    <form method="post" action="http://localhost/users/trycreate">
        <p><b>Введите логин:</b><br>
            <input name="loginCreater" type="text" size="50" value="<?= $_SESSION['customLogin'] ?? '' ?>" required>
        </p>
        <p><b>Введите пароль:</b><br>
            <input name="passwordCreater" type="password" size="50" required>
        </p>
        <p><b>Повторите пароль:</b><br>
            <input name="passwordSecondCreater" type="password" size="50" required>
        </p>
        <p><b>Введите Email:</b><br>
            <input name="emailCreater" type="email" size="50" value="<?= $_SESSION['customEmail'] ?? '' ?>" required>
        </p>
        <p><b>Введите телефон (8XXXXXXXXXX):</b><br>
            <input name="phoneCreater" type="text" pattern="8[0-9]{10}" size="50" value="<?= $_SESSION['customPhone'] ?? '' ?>" required>
        </p>
        <p><b>Выберите роль пользователя:</b><br>
        <p>
            <input type="radio" id="contactChoice1" name="roleCreater" value="Администратор" required>
            <label for="contactChoice1">Администратор</label>
        </p>
        <p>
            <input type="radio" id="contactChoice2" name="roleCreater" value="Клиент" required>
            <label for="contactChoice2">Клиент</label>
        </p>
        <input type="submit" class="btn btn-outline-success" value="Добавить пользователя">
        <input type="reset" class="btn btn-outline-danger" value="Очистить"></p>
    </form>
</div>
</body>
</html>