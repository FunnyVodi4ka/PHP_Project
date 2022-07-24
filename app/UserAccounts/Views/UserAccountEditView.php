<!DOCTYPE HTML PUBLIC "-//W3C//DTD   HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>My profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<p><a href="http://localhost/myprofile" class="btn btn-primary">Назад</a></p>
<div class="divcenter">
    <?php
    while ($row = $stmt->fetch())
    {
        $_POST["Login"] = $row["login"];
        $_POST["Password"] = $row["password"];
        $_POST["Email"] = $row["email"];
        $_POST["Phone"] = $row["phone"];
    }
    ?>
    <h2>Настройки аккаунта</h2>
    <form name="editrecord" method="post" action="http://localhost/myprofile/tryedit" enctype="multipart/form-data">
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