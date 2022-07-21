<?php
if(empty($_POST["idCourseForEdit"])){
  $uri = $_SERVER['REQUEST_URI'];
  $parseUri = explode('/', $uri);
  $_POST["idCourseForEdit"] = (int)$parseUri[2];
  if(count($parseUri) == 4 && $parseUri[1] == 'users' && $parseUri[3] == 'edit') {
      $_POST["idCourseForEdit"] = (int)$parseUri[2];
  }
}

session_start();
if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1 && !empty($_POST['idCourseForEdit'])): ?>

<?php
    unset($_SESSION['customCourse']);
    unset($_SESSION['customAuthor']);
    unset($_SESSION['customContent']);
    require_once('../config/ConnectionToDB.php');
    $stmt = Connection()->prepare('SELECT * FROM Courses WHERE IdCourse = ? AND DeleteAt IS NULL');
    $stmt->execute([$_POST['idCourseForEdit']]);
    while ($row = $stmt->fetch())
    {
        $_POST['course'] = $row['Course'];
        $_POST['author'] = $row['IdAuthor'];
        $_POST['content'] = json_decode($row['Content']);
    }

  //Вывод сообщения
  function alertMessage($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
  }
  
  
  if(isset($_POST['EditFormCourse']) && isset($_POST['EditFormAuthor']) && 
  isset($_POST['EditFormContent'])){
    $_SESSION['customCourse'] = $_POST['EditFormCourse'];
    $_SESSION['customAuthor'] = $_POST['EditFormAuthor'];
    $_SESSION['customContent'] = $_POST['EditFormContent'];

    require_once('../assets/ValidationForCourse.php');
    
    if($_SESSION["is_role"] == 1 && $_SESSION['is_auth'] == true){
    
    $now_idcourse = (int)$_POST['idCourseForEdit'];
    $now_course = $_POST["EditFormCourse"];
    $now_author = (int)$_POST["EditFormAuthor"];
    $now_content = $_POST["EditFormContent"];
    $nowContentData = json_encode($now_content);
    
    if(CheckIdCourse($now_idcourse) && CheckCourse($now_course) && CheckAuthor($now_author) && CheckContent($now_content)){
        $stmt = Connection()->prepare("UPDATE Courses SET Course = ?, IdAuthor = ?, 
            Content = ? WHERE IdCourse = ?");
            if($stmt->execute([$now_course, $now_author, $nowContentData, $now_idcourse])){
                alertMessage("Данные успешно изменены!");
                $_POST = [];
                unset($_SESSION['customCourse']);
                unset($_SESSION['customAuthor']);
                unset($_SESSION['customContent']);
                header("Refresh:0; url=PageTableCourses");
                die();
            } 
            else{
                echo "Ошибка: Повторите попытку позже!";
            }
        }
    }
    else{
        echo "Ошибка доступа, повторите попытку позже!";
    }
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD   HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
  <title>CRUD</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/style.css">
 </head>
 <body>
    <p><a href="http://localhost/PageTableCourses" class="btn btn-primary">Назад</a></p>
<div class="divcenter">
      <h2>Изменение курса в БД</h2>
      <form method="post" action="">
        <p><b>Id курса:</b>
        <input name="idCourseForEdit" type="text" <?php echo "value=".(int)$_POST['idCourseForEdit']; ?> readonly>
        </p>
        <p><b>Введите название:</b><br>
        <input name="EditFormCourse" type="text" size="50" value="<?= $_SESSION['customCourse'] ?? $_POST['course']?>" required>
        </p>
        <p><b>Введите Id автора:</b><br>
        <input name="EditFormAuthor" type="number" value="<?= $_SESSION['customAuthor'] ?? $_POST['author']?>" required>
        </p>
        <p><b>Содержание:</b><br>
        <textarea rows="6" cols="54" name="EditFormContent"><?= $_SESSION['customContent'] ?? $_POST['content']?></textarea>
        </p>
        <input type="submit" class="btn btn-outline-warning" value="Изменить курс">
        <input type="reset" class="btn btn-info" value="Очистить"></p>
      </form>
      </div>
    <div>
    </body>
</html>

<?php else: 
    header("Refresh:0; url=auth");
    die();
endif; ?>