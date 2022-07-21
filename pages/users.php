<?php
  require_once('../config/ConnectionToDB.php');
  $usersCountResult = Connection()->query("SELECT count(*) FROM Users WHERE DeleteAt IS NULL");
  $usersCount = $usersCountResult->fetch();
  $paginationUrl = "users";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Пользователи</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/style.css">
 </head>
 <body>
 <a class="btn btn-primary" href="LogOut" onclick="return  confirm('Вы точно хотите выйти?')">Выход</a>
 <a class="btn btn-primary" href="PageUserAccount">В личный кабинет</a>
 <h2>Список пользователей</h2>
 <?php
  require_once('../assets/pagination.php');
  $stmt = Connection()->query('SELECT IdUser, Login, Password, Email, Phone, Role, AvatarImage FROM Users 
  INNER JOIN Roles ON Users.IdRole = Roles.IdRole 
  WHERE DeleteAt IS NULL ORDER BY IdUser DESC LIMIT '.(($_GET['list']-1)*$PageCount).','.$PageCount.';');

  echo "<table class='table table-striped'><tr><th>Photo</th><th>Id</th><th>Login</th>
  <th>Email</th><th>Phone</th><th>Role</th></tr>";
  while ($row = $stmt->fetch())
  {
  echo "<tr>";
  if(!empty($row["AvatarImage"]) && file_exists($row["AvatarImage"])){
    echo "<td><img src='".$row["AvatarImage"]."' alt='Loading...' width='40' height='40'></td>";
  }
  else{
    echo "<td><img src='userImages/standartPhoto.png' alt='Loading...' width='40' height='40'></td>";
  } 
  echo "<td>" . $row["IdUser"] . "</td>";
  echo "<td>" . $row["Login"] . "</td>";
  echo "<td>" . $row["Email"] . "</td>";
  echo "<td>" . $row["Phone"] . "</td>";
  echo "<td>" . $row["Role"] . "</td>";
  echo "</tr>";
  }
  echo "</table>";
?>
 </body>
</html>