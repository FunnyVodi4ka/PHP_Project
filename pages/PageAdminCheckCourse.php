<?php 
session_start();
if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1 && !empty($_POST["idCourseForCheck"])): 
?>
<?php
    require_once('../config/ConnectionToDB.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Данные о курсе</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
 </head>
 <body>
    <b><a href="PageTableCourses" class="btn btn-primary">Назад</a></b>
    <?php
        session_start();
        $courseId = $_POST["idCourseForCheck"];
        echo "<h2>Данные о курсе с Id: ".$courseId."</h2>";

        $stmt = Connection()->prepare('SELECT Course, Login, Content FROM Courses
        INNER JOIN Users ON Courses.IdAuthor = Users.IdUser WHERE IdCourse = ?');
        $stmt->execute([$courseId]);
        while ($row = $stmt->fetch())
        {
        echo "<p><b>Название курса:</b> ".$row["Course"]."</p>";
        echo "<p><b>Автор:</b> ".$row["Login"]."</p>";
        echo "<p><b>Содержание:</b></p><p>".$row["Content"]."</p>";
        }
    ?>
</body>
</html>
<?php else: 
    header("Refresh:0; url=auth");
    die();
endif; ?>