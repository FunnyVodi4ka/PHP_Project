<?php
class CourseView{
    function printTableCourses(Course $courseObj){
        echo "<table class='table table-striped'><tr><th></th><th>Id</th><th>Course</th>
        <th>Author</th><th>DeleteAt</th><th></th><th></th></tr>";
        if(!empty($this->courseDeleteAt)){
          echo "<tr class='deletedRow'>";
        }
        else{
          echo "<tr>";
        }
        echo "<td><form method='post' action='PageCheckCourse'>
        <input type='number' name='idCourseForCheck' value=".$this->courseId." readonly hidden>
        <input type='submit' class='btn btn-outline-secondary' value='Просмотр'></form></td>";

        echo "<td>" . $this->courseId . "</td>";
        echo "<td>" . $this->courseName . "</td>";
        echo "<td>" . $this->courseIdAuthor . "</td>";
        echo "<td>" . $this->courseDeleteAt . "</td>";

        if(!empty($this->courseDeleteAt)){
          echo "<td colspan='2'><form method='post' action='' onsubmit='recoverName(this);return false;'>
          <input type='number' name='idCourseForRecover' value=".$this->courseId." readonly hidden>
          <input type='submit' class='btn btn-outline-secondary' value='Восстановить'></form></td>";
        }
        else{
          echo "<td><form method='post' action='PageEditCourse'>
          <input type='number' name='idCourseForEdit' value=".$this->courseId." readonly hidden>
          <input type='submit' class='btn btn-outline-warning' value='Редактировать'></form></td>";

          echo "<td><form method='post' action='' onsubmit='deleteName(this);return false;'>
          <input type='number' name='idCourseForDelete' value=".$this->courseId." readonly hidden>
          <input type='submit' class='btn btn-outline-danger' value='Удалить'></form></td>";
        }
        echo "</tr>";
        echo "</table>";
    }
}