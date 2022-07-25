<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Регистрация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<div class="divcenter">
    <h1>Регистрация</h1>
    <form name="tryregister" method="post" action="tryregister">
        <p><b>Введите логин:</b><br>
            <input name="loginRegister" type="text" size="45" value="<?= $_SESSION['customLogin'] ?? '' ?>" required>
        </p>
        <p><b>Введите пароль:</b><br>
            <input name="passwordRegister" type="password" size="45" required>
        </p>
        <p><b>Повторите пароль:</b><br>
            <input name="passwordSecondRegister" type="password" size="45" required>
        </p>
        <p><b>Введите Email:</b><br>
            <input name="emailRegister" type="email" size="45" value="<?= $_SESSION['customEmail'] ?? '' ?>" required>
        </p>
        <p><b>Введите телефон (8XXXXXXXXXX):</b><br>
            <input name="phoneRegister" type="text" pattern="8[0-9]{10}" size="40" value="<?= $_SESSION['customPhone'] ?? '' ?>" required>
        </p>
        <input type="submit" class="btn btn-outline-success" value="Создать аккаунт">
        <a href="auth" class="btn btn-outline-warning">Авторизоваться</a>
        <input type="reset" class="btn btn-outline-danger" value="Очистить">
    </form>
</div>
<?php
if(!empty($_SESSION['errorArray'])) {
    echo "<div class='divcenter'>";
    echo "<div class='errorbox'>";
    foreach ($_SESSION['errorArray'] as $row) {
        echo "<p>" . $row . "</p>";
    }
    echo "</div>";
    echo "</div>";
}
?>
</body>
</html>