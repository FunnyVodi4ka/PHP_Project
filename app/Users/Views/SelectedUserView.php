<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>User profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">
</head>
<div>
<b><a href="http://localhost/users" class="btn btn-primary">Назад</a></b>
<?php
while ($row = $stmt->fetch())
{
    echo "<h2>Аккаунт клиента с Id: ".$row["user_id"]."</h2>";
    echo "<p><b>Статус пользователя: </b>";
    if(empty($row["deleted_at"])){
        echo "<b class='statusTextActive'>Active</b></p>";
    }
    else{
        echo "<b class='statusTextDeleted'>Deleted</b></p>";
    }
    echo "<p><b>Логин пользователя:</b> ".$row["login"]."</p>";
    echo "<p><b>Почта пользователя:</b> ".$row["email"]."</p>";
    echo "<p><b>Телефон пользователя:</b> ".$row["phone"]."</p>";
    echo "<p><b>Роль пользователя:</b> ".$row["role_name"]."</p>";
    echo "<p><b>Фотография пользователя:</b> "."</p>";
    if(!empty($row["avatar_image"]) && file_exists($_SERVER['DOCUMENT_ROOT'].$row["avatar_image"])){
        echo "<p><img src='".$row["avatar_image"]."' alt='Loading...' width='200' height='200'></p>";
    }
    else{
        echo "<p><img src='/public/userImages/standartPhoto.png' alt='Loading...' width='200' height='200'></p>";
    }
}
?>
</div>
</body>
</html>