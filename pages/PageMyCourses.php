<?php
  require_once('../config/ConnectionToDB.php');

  session_start();
  //Пагинация
  if(isset($_GET['PageRows'])){
    $_SESSION['PageRows'] = $_GET['PageRows'];
  }

  if(empty($_SESSION['PageRows'])){
    $PageCount = 10;
  } else{
    $PageCount = $_SESSION['PageRows'];
  }

  if(!isset($_GET['list'])) {
    $_GET['list'] = 1;
  }
  $usersCountResult = Connection()->prepare("SELECT count(*) FROM Courses WHERE IdAuthor = ? AND DeleteAt IS NULL");
  $id = (int)$_SESSION['is_userid'];
  $usersCountResult->execute([$id]);
  $usersCount = $usersCountResult->fetch();

  if ($_GET['list'] > $usersCount['count(*)'] / $PageCount){
    $_GET['list'] = ceil($usersCount['count(*)'] / $PageCount);
  }

  if ($_GET['list'] < 1){
    $_GET['list'] = 1;
  }
  $paginationUrl = "PageMyCourses";
  //--
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Мои курсы</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
 </head>
 <body>
 <a class="btn btn-primary" href="LogOut" onclick="return  confirm('Вы точно хотите выйти?')">Выход</a>
 <a class="btn btn-primary" href="PageUserAccount">В личный кабинет</a>
 <h2>Список моих курсов</h2>
 <?php
  require_once('../assets/pagination.php');
  $stmt = Connection()->prepare('SELECT * FROM Courses
  INNER JOIN Users ON Courses.IdAuthor = Users.IdUser 
  WHERE IdUser = ? LIMIT '.(($_GET['list']-1)*$PageCount).','.$PageCount.';');
  $id = (int)$_SESSION['is_userid'];
  $stmt->execute([$id]);
  echo "<table class='table table-striped'><tr><th>Id</th><th>Course</th><th>Author</th>
  <th>Content</th></tr>";
  while ($row = $stmt->fetch())
  {
  echo "<tr>";
  echo "<td>" . $row["IdCourse"] . "</td>";
  echo "<td>" . $row["Course"] . "</td>";
  echo "<td>" . $row["Login"] . "</td>";
  echo "<td>" . $row["Content"] . "</td>";
  echo "</tr>";
  }
  echo "</table>";
?>
 </body>
</html>