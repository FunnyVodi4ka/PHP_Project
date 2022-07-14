<?php
    require_once('ConnectionValidation.php');
    
    session_start();
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
  <title>Авторизация</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
 </head>
 <body>
 <a class="btn btn-primary" href="LogOut.php" onclick="return  confirm('Вы точно хотите выйти?')">Выход</a>
 <a class="btn btn-primary" href="PageUserAccount.php">В личный кабинет</a>
 <h2>Список пользователей</h2>

<nav>
  <ul class="pagination justify-content-center">
  <li class="page-item">
      <a class="page-link" href="/users.php?list=1">
        Первая
      </a>
    </li>

    <li class="page-item">
        <a class="page-link" href="/users.php?= $_GET['list']-1 ?>"><<</a>
    </li>

  <?php if(!($_GET['list'] < 3)): ?>
      <li class="page-item">
        <a class="page-link" href="/users.php?list=<?= $_GET['list']-2 ?>"><?= $_GET['list']-2 ?></a>
      </li>
    <?php endif ?>
      
    <?php if(!($_GET['list'] < 2)): ?>  
      <li class="page-item">
        <a class="page-link" href="/users.php?list=<?= $_GET['list']-1 ?>"><?= $_GET['list']-1 ?></a>
      </li>
    <?php endif ?>

    <li class="page-item active">
      <a class="page-link" href="/users.php?list=<?= $_GET['list'] ?>"><?= $_GET['list'] ?></a>
    </li>

    <?php if(!($_GET['list']+1 > $usersCount['count(*)'] / $PageCount)): ?>
      <li class="page-item">
        <a class="page-link" href="/users.php?list=<?= $_GET['list']+1 ?>"><?= $_GET['list']+1 ?></a>
      </li>
    <?php endif ?>

    <?php if(!($_GET['list']+2 > $usersCount['count(*)'] / $PageCount)): ?>
      <li class="page-item">
        <a class="page-link" href="/users.php?list=<?= $_GET['list']+1 ?>"><?= $_GET['list']+2 ?></a>
      </li>
    <?php endif ?>

    <li class="page-item">
        <a class="page-link" href="/users.php?list=<?= $_GET['list']+1 ?>">>></a>
    </li>

    <li class="page-item">
      <a class="page-link" href="/users.php?list=<?= ceil($usersCount['count(*)'] / $PageCount) ?>">
        Последняя
      </a>
    </li>
    <form method="get">
    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="PageRows" onchange="form.submit();">
      <option value="10" <?php if ($_SESSION['PageRows'] == 10) {echo "selected";}?>>10</option>
      <option value="25" <?php if ($_SESSION['PageRows'] == 25) {echo "selected";}?>>25</option>
      <option value="50" <?php if ($_SESSION['PageRows'] == 50) {echo "selected";}?>>50</option>
    </select>
    </form>
    </ul>
</nav>
 <?php
    require_once('ConnectionValidation.php');
    $stmt = Connection()->query('SELECT IdUser, Login, Password, Email, Phone, Role, AvatarImage FROM Users 
    INNER JOIN Roles ON Users.IdRole = Roles.IdRole 
    WHERE DeleteAt IS NULL ORDER BY IdUser DESC LIMIT '.(($_GET['list']-1)*$PageCount).','.$PageCount.';');

    echo "<table class='table table-striped'><tr><th>Photo</th><th>Id</th><th>Login</th>
    <th>Email</th><th>Phone</th><th>Role</th></tr>";
    while ($row = $stmt->fetch())
    {
    echo "<tr>";
    if(empty($row["AvatarImage"])){
        echo "<td><img src='userImages/standartPhoto.png' alt='Loading...' width='40' height='40'></td>";
      }
      else{
        echo "<td><img src='".$row["AvatarImage"]."' alt='Loading...' width='40' height='40'></td>";
      }
    echo "<td>" . $row["IdUser"] . "</td>";
    echo "<td>" . $row["Login"] . "</td>";
    echo "<td>" . $row["Email"] . "</td>";
    echo "<td>" . $row["Phone"] . "</td>";
    echo "<td>" . $row["Role"] . "</td>";
    echo "</tr>";
    }
    echo "</table>";
?>
 </body>
</html>