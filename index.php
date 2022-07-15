<?php 

require('Router.php');
Router::route('/users', function(){
  include 'users.php';
  die();
});
Router::route('/register', function(){
  include 'register.php';
  die();
});
Router::route('/auth', function(){
  include 'auth.php';
  die();
});
Router::route('/PageCreateUser', function(){
  include 'PageCreateUser.php';
  die();
});
Router::route('/PageEditUser', function(){
  include 'PageEditUser.php';
  die();
});
Router::route('/PageUserAccountEdit', function(){
  include 'PageUserAccountEdit.php';
  die();
});
Router::route('/PageUserAccount', function(){
  include 'PageUserAccount.php';
  die();
});
Router::route('/LogOut', function(){
  include 'LogOut.php';
  die();
});
Router::execute($_SERVER['REQUEST_URI']);

session_start();
if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1): 
?>

<?php
  require_once('ConnectionValidation.php');

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
  <link rel="stylesheet" href="styles/style.css">
  <?php
    function CheckAuthorization(){
      echo '<meta http-equiv="refresh" content="0;URL=http://localhost/auth"/>';
    }
  ?>
 </head>
 <body>
    <div class="exit">
      <b>
        <a class="btn btn-primary" href="LogOut" onclick="return  confirm('Вы точно хотите выйти?')">Выход</a>
      </b>
      <b>Добрый день, Администратор!</b>
    </div>
    <h2>Список пользователей</h2>

    <?php 
      require_once('pagination.php');
    ?>
    <a href="PageCreateUser" class='btn btn-outline-success'>Создать запись</a>
    <?php
      $stmt = Connection()->query('SELECT IdUser, Login, Password, Email, Phone, Role, AvatarImage FROM Users 
      INNER JOIN Roles ON Users.IdRole = Roles.IdRole 
      WHERE DeleteAt IS NULL ORDER BY IdUser DESC LIMIT '.(($_GET['list']-1)*$PageCount).','.$PageCount.';');

      echo "<table class='table table-striped'><tr><th></th><th>Photo</th><th>Id</th><th>Login</th>
      <th>Email</th><th>Phone</th><th>Role</th><th></th><th></th></tr>";
      while ($row = $stmt->fetch())
      {
        echo "<tr>";
        echo "<td><form method='post' action='PageAdminCheckUser'>
        <input type='number' name='idUserForCheck' value=".$row["IdUser"]." readonly hidden>
        <input type='submit' class='btn btn-outline-secondary' value='Просмотр'></form></td>";

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

        echo "<td><form method='post' action='PageEditUser'>
        <input type='number' name='iduser' value=".$row["IdUser"]." readonly hidden>
        <input type='text' name='login' value=".$row["Login"]." readonly hidden>
        <input type='text' name='email' value=".$row["Email"]." readonly hidden>
        <input type='text' name='phone' value=".$row["Phone"]." readonly hidden>
        <input type='text' name='role' value=".$row["Role"]." readonly hidden>
        <input type='submit' class='btn btn-outline-warning' value='Редактировать'></form></td>";

        echo "<td><form method='post' action='/' onsubmit='deleteName(this);return false;'>
        <input type='number' name='idUserForDelete' value=".$row["IdUser"]." readonly hidden>
        <input type='submit' class='btn btn-outline-danger' value='Удалить'></form></td>";
        echo "</tr>";
      }
      echo "</table>";
    ?>
      </div>
 </body>
</html>
<?php else: 
    header("Refresh:0; url=auth");
    die();
endif; ?>