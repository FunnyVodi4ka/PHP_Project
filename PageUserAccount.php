<?php 
session_start();
if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 2): ?>
<?php
    require_once('ConnectionValidation.php');
  
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
  
    if ($_GET['list'] > $usersCount['count(*)'] / $PageCount) {
      $_GET['list'] = ceil($usersCount['count(*)'] / $PageCount);
    }
  
    if ($_GET['list'] < 1){
      $_GET['list'] = 1;
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Ваш аккаунт</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
 </head>
 <body>
    <b><a href="LogOut.php" class="btn btn-primary" onclick="return  confirm('Вы точно хотите выйти?')">Выход</a></b>
    <b>Добрый день, Клиент!</b>
    <h2>Ваши данные:</h2>
    <?php
        session_start();
        $userId = $_SESSION["is_userid"];

        $stmt = Connection()->prepare('SELECT Login, Email, Phone, Role, AvatarImage FROM Users 
        INNER JOIN Roles ON Users.IdRole = Roles.IdRole WHERE IdUser = ?');
        $stmt->execute([$userId]);
        while ($row = $stmt->fetch())
        {
        echo "<p><b>Ваш логин:</b> ".$row["Login"]."</p>";
        echo "<p><b>Ваша почта:</b> ".$row["Email"]."</p>";
        echo "<p><b>Ваш телефон:</b> ".$row["Phone"]."</p>";
        echo "<p><b>Ваша роль:</b> ".$row["Role"]."</p>";
        echo "<p><b>Ваша фотография:</b> "."</p>";
        if(!empty($row["AvatarImage"]) && file_exists($row["AvatarImage"])){
          echo "<p><img class='profile__img' src='".$row["AvatarImage"]."' alt='Loading...' width='200' height='200'></p>";
        }
        else{
          echo "<p><img class='profile__img' src='userImages/standartPhoto.png' alt='Loading...' width='200' height='200'></p>";
        }
      }
    ?>
    <a class="btn btn-warning" href="PageUserAccountEdit.php">Изменить данные</a>
    <h2>Список пользователей</h2>
    <div class="divcenter">
    <a class="btn btn-primary" href="users.php">Просмотреть список пользователей</a>
    </div>
 </body>
</html>

<?php else: 
    header("Refresh:0; url=auth.php");
    die();
endif; ?>