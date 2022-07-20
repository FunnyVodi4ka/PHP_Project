<?php
session_start();
if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1): 
?>

<?php
  require_once('../config/ConnectionToDB.php');
  require_once('../assets/ValidationForCourse.php');
  $usersCountResult = Connection()->query("SELECT count(*) FROM Courses WHERE DeleteAt IS NULL");
  $usersCount = $usersCountResult->fetch();
  $paginationUrl = "PageTableCourses";

  //Вывод сообщения
  function alertMessage($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
  }

  //Удаление курсов
  if(isset($_POST['idCourseForDelete'])){
    if($_SESSION["is_role"] == 1 && $_SESSION['is_auth'] == true){
        $now_idcourse = (int)$_POST['idCourseForDelete'];
        if(CheckIdCourse($now_idcourse)){
            $stmt = Connection()->prepare('UPDATE Courses SET DeleteAt = NOW() WHERE IdCourse = ?;');
            $stmt->execute([$now_idcourse]);
            alertMessage("Данные успешно удалены!");
        }
        else{
            alertMessage("\nОшибка: Данные не удалены!");
        }
    }
    else{
      alertMessage("Ошибка доступа, повторите попытку позже!");
    }
    unset($_POST['idCourseForDelete']);
    header("Refresh:0");
    die();
  }
  //--
  //Восстановление курсов
  if(isset($_POST['idCourseForRecover'])){
    if($_SESSION["is_role"] == 1 && $_SESSION['is_auth'] == true){
        $now_idcourse = (int)$_POST['idCourseForRecover'];
        if(CheckIdCourse($now_idcourse)){
            $stmt = Connection()->prepare('UPDATE Courses SET DeleteAt = NULL WHERE IdCourse = ?;');
            $stmt->execute([$now_idcourse]);
            alertMessage("Данные успешно восстановлены!");
        }
        else{
            alertMessage("\nОшибка: Данные не восстановлены!");
        }
    }
    else{
      alertMessage("Ошибка доступа, повторите попытку позже!");
    }
    unset($_POST['idCourseForRecover']);
    header("Refresh:0");
    die();
  }
  //--
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>CRUD Courses</title>    
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
  <link rel="stylesheet" type="text/css" href="../css/style.css">
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
    <a href="PageCreateCourse" class='btn btn-outline-success'>Создать запись</a>
    <?php
      $stmt = Connection()->query('SELECT IdCourse, Course, IdAuthor, Content, DeleteAt FROM Courses 
      ORDER BY IdCourse DESC LIMIT '.(($_GET['list']-1)*$PageCount).','.$PageCount.';');
    echo "<table class='table table-striped'><tr><th></th><th>Id</th><th>Course</th>
    <th>Author</th><th>DeleteAt</th><th></th><th></th></tr>";
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
    ?>
      </div>
<?php else: 
    header("Refresh:0; url=auth");
    die();
endif; ?>