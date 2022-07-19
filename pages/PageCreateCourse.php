<?php 
session_start();
if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1): ?>

<?php
    unset($_SESSION['customCourse']);
    unset($_SESSION['customAuthor']);
    unset($_SESSION['customContent']);
  if(isset($_POST['CreateFormCourse']) && isset($_POST['CreateFormAuthor']) && 
  isset($_POST['CreateFormContent'])){
    $_SESSION['customCourse'] = $_POST['CreateFormCourse'];
    $_SESSION['customAuthor'] = $_POST['CreateFormAuthor'];
    $_SESSION['customContent'] = $_POST['CreateFormContent'];

    require_once('../config/ConnectionToDB.php');
    require_once('../assets/ValidationForCourse.php');

    if($_SESSION["is_role"] == 1 && $_SESSION['is_auth'] == true){
        $connection = new mysqli("localhost", "root", "Password_12345", "CrudDatabase");
        if($connection->connect_error){
            die("Ошибка: " . $connection->connect_error);
        }

        $now_course = $connection->real_escape_string($_POST["CreateFormCourse"]);
        $now_author = $connection->real_escape_string($_POST["CreateFormAuthor"]);
        $now_content = $connection->real_escape_string($_POST["CreateFormContent"]);

        if(CheckCourse($now_course) && CheckAuthor($now_author) && CheckContent($now_content)){
            $query = "INSERT INTO Courses (Course, IdAuthor, Content) 
            VALUES ('$now_course', '$now_author', '$now_content')";
            if($connection->query($query)){
                unset($_SESSION['customCourse']);
                unset($_SESSION['customAuthor']);
                unset($_SESSION['customContent']);
                $_POST = [];
                echo "Данные успешно добавлены!";
            } else{
                echo "Ошибка: " . $connection->error;
            }
        }
    }
    else{
        echo "Ошибка доступа, повторите попытку позже!";
    }
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>CRUD</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
 </head>
 <body>
  <p><a href="PageTableCourses" class="btn btn-primary">Назад</a></p>
<div class="divcenter">
        <h2>Добавление курса в БД</h2>
        <form method="post" action="">
        <p><b>Введите название:</b><br>
        <input name="CreateFormCourse" type="text" size="50" value="<?= $_SESSION['customCourse'] ?? '' ?>" required>
        </p>
        <p><b>Введите Id автора:</b><br>
        <input name="CreateFormAuthor" type="number" value="<?= $_SESSION['customAuthor'] ?? '' ?>" required>
        </p>
        <p><b>Содержание:</b><br>
        <textarea rows="6" cols="54" name="CreateFormContent"><?= $_SESSION['customContent'] ?? '' ?></textarea>
        </p>
        <input type="submit" class="btn btn-outline-success" value="Добавить курс">
        <input type="reset" class="btn btn-info" value="Очистить"></p>
      </form>
      </div>
      </body>
</html>
<?php else: 
    header("Refresh:0; url=auth");
    die();
endif; ?>