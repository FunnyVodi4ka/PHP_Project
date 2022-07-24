<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>My profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<b><a href="http://localhost/LogOut" class="btn btn-primary" onclick="return  confirm('Вы точно хотите выйти?')">Выход</a></b>
<b>Добрый день, Клиент!</b>
<h2>Ваши данные:</h2>
<div class="accountbox">
    <?php
    while ($row = $stmt->fetch())
    {
        echo "<p><b>Ваш логин:</b> ".$row["login"]."</p>";
        echo "<p><b>Ваша почта:</b> ".$row["email"]."</p>";
        echo "<p><b>Ваш телефон:</b> ".$row["phone"]."</p>";
        echo "<p><b>Ваша роль:</b> ".$row["role_name"]."</p>";
        echo "<p><b>Ваша фотография:</b> "."</p>";
        if(!empty($row["avatar_image"]) && file_exists($_SERVER['DOCUMENT_ROOT'].$row["avatar_image"])){
            echo "<p><img class='profile__img' src='".$row["avatar_image"]."' alt='Loading...' width='200' height='200'></p>";
        }
        else{
            echo "<p><img class='profile__img' src='/public/userImages/standartPhoto.png' alt='Loading...' width='200' height='200'></p>";
        }
    }
    ?>
    <a class="btn btn-warning" href="http://localhost/myprofile/edit">Изменить данные</a>
</div>
<h2>Актуальная информация:</h2>
<div class="divcenter">
    <a class="btn btn-info" href="http://localhost/listusers">Просмотреть список пользователей</a>
</div>
<div class="divcenter">
    <a class="btn btn-info" href="http://localhost/mycourses">Просмотреть список моих курсов</a>
</div>
</body>
</html>