<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Пользователи</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<a class="btn btn-primary" href="http://localhost/LogOut" onclick="return  confirm('Вы точно хотите выйти?')">Выход</a>
<a class="btn btn-primary" href="http://localhost/myprofile">В личный кабинет</a>
<h2>Список пользователей</h2>
<?php
echo "<table class='table table-striped'><tr><th></th><th>Фото</th><th>Id</th><th>Логин</th>
  <th>Почта</th><th>Телефон</th><th>Роль</th></tr>";
while ($row = $stmt->fetch())
{
    echo "<tr>";
    echo "<td><a class='btn btn-outline-secondary' href='http://localhost/listusers/".$row["user_id"]."/view'>Просмотр</a></td>";
    if(!empty($row["avatar_image"]) && file_exists($_SERVER['DOCUMENT_ROOT'].$row["avatar_image"])){
        echo "<td><img src='".$row["avatar_image"]."' alt='Loading...' width='55' height='55'></td>";
    }
    else{
        echo "<td><img src='/public/userImages/standartPhoto.png' alt='Loading...' width='55' height='55'></td>";
    }
    echo "<td>" . $row["user_id"] . "</td>";
    echo "<td>" . $row["login"] . "</td>";
    echo "<td>" . $row["email"] . "</td>";
    echo "<td>" . $row["phone"] . "</td>";
    echo "<td>" . $row["role_name"] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
</body>
</html>