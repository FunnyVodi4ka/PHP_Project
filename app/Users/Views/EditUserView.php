<!DOCTYPE HTML PUBLIC "-//W3C//DTD   HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<p><a href="http://localhost/users" class="btn btn-primary">Назад</a></p>
<div class="divcenter">
    <h2>Изменение пользователя в БД</h2>
    <form name="editrecord" method="post" action="http://localhost/users/tryedit">
        <p><b>Id пользователя:</b>
            <input name="idUserForEdit" type="text" <?php echo "value=".(int)$_POST['idUserForEdit']; ?> readonly>
        </p>
        <p><b>Введите новый логин:</b><br>
            <input name="loginEditer" type="text" size="50" value="<?= $_SESSION['customLogin'] ?? $_POST['login']?>" required>
        </p>
        <p><b>Введите новый пароль:</b><br>
            <input name="passwordEditer" type="password" size="50">
        </p>
        <p><b>Введите новый Email:</b><br>
            <input name="emailEditer" type="email" size="50" value="<?= $_SESSION['customEmail'] ?? $_POST['email']?>" required>
        </p>
        <p><b>Введите новый телефон (8XXXXXXXXXX):</b><br>
            <input name="phoneEditer" type="text" pattern="8[0-9]{10}" size="50" value="<?= $_SESSION['customPhone'] ?? $_POST['phone']?>" required>
        </p>
        <p><b>Выберите новую роль пользователя:</b><br>
        <p>
            <input type="radio" id="contactChoice1" name="roleEditer" value="Администратор"
                <?php
                if($_POST['role'] == "Администратор"){
                    echo "checked";
                }?> required <?php if($_POST['idUserForEdit'] == $_SESSION['is_userid']) echo "disabled"; ?>>
            <label for="contactChoice1">Администратор</label>
        </p>
        <p>
            <input type="radio" id="contactChoice2" name="roleEditer" value="Клиент"
                <?php
                if($_POST['role'] == "Клиент"){
                    echo "checked";
                }?> required <?php if($_POST['idUserForEdit'] == $_SESSION['is_userid']) echo "disabled"; ?>>
            <label for="contactChoice2">Клиент</label>
        </p>
        <input type="submit" class="btn btn-outline-warning" value="Изменить пользователя">
        <input type="reset" class="btn btn-outline-danger" value="Очистить"></p>
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