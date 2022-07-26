<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>List Users</title>
    <script>
        function deleteName(f) {
            if (confirm("Вы уверены, что хотите удалить запись?")){
                f.submit();
            }
        }
        function recoverName(f) {
            if (confirm("Вы уверены, что хотите восстановить запись?")){
                f.submit();
            }
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/styles/style.css">
</head>
<body>
<div class="exit">
    <b>
        <a class="btn btn-primary" href="http://localhost/LogOut" onclick="return  confirm('Вы точно хотите выйти?')">Выход</a>
        <a class="btn btn-primary" href="http://localhost/adminpanel">Назад</a>
    </b>
    <b>Добрый день, Администратор!</b>
</div>
<h2>Список пользователей</h2>
<a href="http://localhost/users/create" class='btn btn-outline-success'>Создать запись</a>
<?php
echo "<table class='table table-striped'><tr><th></th><th>Photo</th><th>Id</th><th>Login</th>
      <th>Email</th><th>Phone</th><th>Role</th><th></th><th></th></tr>";
while ($row = $stmt->fetch())
{
    if(!empty($row['deleted_at'])){
        echo "<tr class='deletedRow'>";
    }
    else{
        echo "<tr>";
    }
    echo "<td><a class='btn btn-outline-secondary' href='http://localhost/users/".$row["user_id"]."/view'>Просмотр</a></td>";

    if(!empty($row["avatar_image"]) && file_exists($_SERVER['DOCUMENT_ROOT'].$row["avatar_image"])){
        echo "<td><img src='".$row["avatar_image"]."' alt='Loading...' width='50' height='50'></td>";
    }
    else{
        echo "<td><img src='/public/userImages/standartPhoto.png' alt='Loading...' width='50' height='50'></td>";
    }
    echo "<td>" . $row["user_id"] . "</td>";
    echo "<td>" . $row["login"] . "</td>";
    echo "<td>" . $row["email"] . "</td>";
    echo "<td>" . $row["phone"] . "</td>";
    echo "<td>" . $row["role_name"] . "</td>";

    if(!empty($row['deleted_at'])){
        echo "<td colspan='2'><a class='btn btn-outline-secondary' href='http://localhost/users/".$row["user_id"]."/recover' onclick='recoverName(this);return false;'>Восстановить</a></td>";
    }
    else{
        echo "<td><a class='btn btn-outline-warning' href='http://localhost/users/".$row["user_id"]."/update'>Редактировать</a></td>";

        echo "<td><a class='btn btn-outline-danger' href='http://localhost/users/".$row["user_id"]."/delete' onclick='deleteName(this);return false;'>Удалить</a></td>";
    }
    echo "</tr>";
}
echo "</table>";
?>
</div>
</body>
</html>