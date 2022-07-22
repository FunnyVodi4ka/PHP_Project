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
        echo "<td><form method='post' action='PageCheckCourse'>
        <input type='number' name='idCourseForCheck' value=".$row["IdCourse"]." readonly hidden>
        <input type='submit' class='btn btn-outline-secondary' value='Просмотр'></form></td>";

        echo "<td>" . $row["IdCourse"] . "</td>";
        echo "<td>" . $row["Course"] . "</td>";
        echo "<td>" . $row["IdAuthor"] . "</td>";
        echo "<td>" . $row["DeleteAt"] . "</td>";

        if(!empty($row['DeleteAt'])){
          echo "<td colspan='2'><form method='post' action='' onsubmit='recoverName(this);return false;'>
          <input type='number' name='idCourseForRecover' value=".$row["IdCourse"]." readonly hidden>
          <input type='submit' class='btn btn-outline-secondary' value='Восстановить'></form></td>";
        }
        else{
          echo "<td><form method='post' action='PageEditCourse'>
          <input type='number' name='idCourseForEdit' value=".$row["IdCourse"]." readonly hidden>
          <input type='submit' class='btn btn-outline-warning' value='Редактировать'></form></td>";

          echo "<td><form method='post' action='' onsubmit='deleteName(this);return false;'>
          <input type='number' name='idCourseForDelete' value=".$row["IdCourse"]." readonly hidden>
          <input type='submit' class='btn btn-outline-danger' value='Удалить'></form></td>";
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
 </head>
 <body>
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