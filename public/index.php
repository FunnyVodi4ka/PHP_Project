<?php
require('../assets/Router.php');
Router::route('/users', function(){
  include '../pages/users.php';
  die();
});
Router::route('/register', function(){
  include '../pages/register.php';
  die();
});
Router::route('/auth', function(){
  include '../pages/auth.php';
  die();
});
Router::route('/PageCreateUser', function(){
  include '../pages/PageCreateUser.php';
  die();
});
Router::route('/PageEditUser', function(){
  include '../pages/PageEditUser.php';
  die();
});
Router::route('/PageUserAccountEdit', function(){
  include '../pages/PageUserAccountEdit.php';
  die();
});
Router::route('/PageUserAccount', function(){
  include '../pages/PageUserAccount.php';
  die();
});
Router::route('/LogOut', function(){
  include '../assets/LogOut.php';
  die();
});
Router::route('/PageAdminCheckUser', function(){
  include '../pages/PageAdminCheckUser.php';
  die();
});
Router::route('/PageTableUsers', function(){
  include '../pages/PageTableUsers.php';
  die();
});
Router::route('/PageTableCourses', function(){
  include '../pages/PageTableCourses.php';
  die();
});
Router::execute($_SERVER['REQUEST_URI']);

session_start();
if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1): 
?>

<?php
  require_once('../config/ConnectionToDB.php');
  require_once('../assets/ValidationForUsers.php');
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
  $usersCountResult = Connection()->query("SELECT count(*) FROM Users WHERE DeleteAt IS NULL");
  $usersCount = $usersCountResult->fetch();

  if ($_GET['list'] > $usersCount['count(*)'] / $PageCount){
    $_GET['list'] = ceil($usersCount['count(*)'] / $PageCount);
  }

  if ($_GET['list'] < 1){
    $_GET['list'] = 1;
  }
  $paginationUrl = "";
  //--

  //Вывод сообщения
  function alertMessage($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
  }

  //Удаление пользователя
  if(isset($_POST['idUserForDelete'])){
    session_start();
    if($_SESSION["is_role"] == 1 && $_SESSION['is_auth'] == true){
        $now_iduser = (int)$_POST['idUserForDelete'];
        if($now_iduser != $_SESSION['is_userid']){
            if(CheckIdUser($now_iduser)){
                $stmt = Connection()->prepare('UPDATE Users SET DeleteAt = NOW() WHERE IdUser = ?;');
                $stmt->execute([$now_iduser]);
                alertMessage("Данные успешно удалены!");
            }
            else{
              alertMessage("\nОшибка: Данные не удалены!");
            }
        }
        else{
          alertMessage("Вы не можете удалить сами себя!");
        }
    }
    else{
      alertMessage("Ошибка доступа, повторите попытку позже!");
    }
    unset($_POST['idUserForDelete']);
    header("Refresh:0");
    die();
  }
  //--
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>CRUD</title>    
  <script>
   function deleteName(f) {
    if (confirm("Вы уверены, что хотите удалить запись?")){
      f.submit();
    }
   }
  </script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/style.css">
 </head>
 <body>
    <div class="exit">
      <b>
        <a class="btn btn-primary" href="LogOut" onclick="return  confirm('Вы точно хотите выйти?')">Выход</a>
      </b>
      <b>Добрый день, Администратор!</b>
    </div>
    <div class="divcenter">
      <h2>Активные таблицы</h2>
      <p><a class="btn btn-info" href="PageTableUsers">Таблица "Пользователи"</a></p>
      <p><a class="btn btn-info" href="PageTableCourses">Таблица "Курсы"</a></p>
    </div>
 </body>
</html>
<?php else: 
    header("Refresh:0; url=auth");
    die();
endif; ?>