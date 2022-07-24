<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<a class="btn btn-primary" href="http://localhost/LogOut" onclick="return  confirm('Вы точно хотите выйти?')">Выход</a>
<a class="btn btn-primary" href="http://localhost/myprofile">В личный кабинет</a>
<h2>Список пользователей</h2>
<?php
//require_once('../assets/pagination.php');
echo "<table class='table table-striped'><tr><th>Photo</th><th>Id</th><th>Login</th>
  <th>Email</th><th>Phone</th><th>Role</th></tr>";
while ($row = $stmt->fetch())
{
    echo "<tr>";
    if(!empty($row["avatar_image"]) && file_exists($_SERVER['DOCUMENT_ROOT'].$row["avatar_image"])){
        echo "<td><img src='".$row["avatar_image"]."' alt='Loading...' width='40' height='40'></td>";
    }
    else{
        echo "<td><img src='/public/userImages/standartPhoto.png' alt='Loading...' width='40' height='40'></td>";
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