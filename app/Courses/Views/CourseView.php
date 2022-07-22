<?php
class CourseView{
  public function printTableCourses($stmt){
    while ($row = $stmt->fetch())
    {
        if(!empty($row['DeleteAt'])){
          echo "<tr class='deletedRow'>";
        } 
        else{
          echo "<tr>";
        }
        echo "<td><a class='btn btn-outline-secondary' href='http://localhost/courses/".$row["IdCourse"]."/view'>Просмотр</a></td>";

        echo "<td>" . $row["IdCourse"] . "</td>";
        echo "<td>" . $row["Course"] . "</td>";
        echo "<td>" . $row["IdAuthor"] . "</td>";
        echo "<td>" . $row["DeleteAt"] . "</td>";

        if(!empty($row['DeleteAt'])){
          echo "<td colspan='2'><a class='btn btn-outline-secondary' href='http://localhost/courses/".$row["IdCourse"]."/recover'>Восстановить</a></td>";
        }
        else{
          echo "<td><a class='btn btn-outline-warning' href='http://localhost/courses/".$row["IdCourse"]."/edit'>Редактировать</a></td>";

          echo "<td><a class='btn btn-outline-danger' href='http://localhost/courses/".$row["IdCourse"]."/delete'>Удалить</a></td>";
        }
        echo "</tr>";
      }
      echo "</table>";
  }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD   HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
  <title>Courses</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/style.css">
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
 </head>
 <body>
 <div class="exit">
      <b>
        <a class="btn btn-primary" href="LogOut" onclick="return  confirm('Вы точно хотите выйти?')">Выход</a>
        <a class="btn btn-primary" href="PageAdminPanel">Назад</a>
      </b>
      <b>Добрый день, Администратор!</b>
    </div>
    <h2>Список курсов</h2>
    <?php 
      require_once('../assets/pagination.php');
    ?>
 <table class='table table-striped'>
  <tr>
    <th></th>
    <th>Id</th>
    <th>Course</th>
    <th>Author</th>
    <th>DeleteAt</th>
    <th></th>
    <th></th>
  </tr>
 </body>
</html>