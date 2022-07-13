<?php
  session_start();
  if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1){
    header("Refresh:0; url=index2.php");
  }
  elseif($_SESSION["is_auth"] && $_SESSION["is_role"] == 2){
    header("Refresh:0; url=PageUserAccount.php");
  }

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
  <title>Авторизация</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
 </head>
 <body>
 <br>
  <h1>Авторизация</h1>
  <div class="divcenter">
    <form name="register" method="post" action="TryEnter.php">
        <p><b>Введите логин:</b><br>
        <input name="enter_login" type="text" size="40" required>
        </p>
        <p><b>Введите пароль:</b><br>
        <input name="enter_password" type="password" size="40" required>
        </p>
        <input type="submit" class="btn btn-outline-success" value="Войти">
        <a href="PageRegister.php" class="btn btn-outline-warning">Регистрация</a>
        <input type="reset" class="btn btn-outline-danger" value="Очистить">
      </form>
      <p><a href="index2.php" class="btn btn-outline-primary" hidden>Админ-панель</a></p>
      <p><a href="PageUserAccount.php" class="btn btn-outline-primary" hidden>Вход в личный кабинет</a></p>
    </div>
    <h2>Список пользователей</h2>

<nav>
  <ul class="pagination justify-content-center">
  <li class="page-item">
      <a class="page-link" href="/?list=1">
        Первая
      </a>
    </li>

    <li class="page-item">
        <a class="page-link" href="/?list=<?= $_GET['list']-1 ?>"><<</a>
    </li>

  <?php if(!($_GET['list'] < 3)): ?>
      <li class="page-item">
        <a class="page-link" href="/?list=<?= $_GET['list']-2 ?>"><?= $_GET['list']-2 ?></a>
      </li>
    <?php endif ?>
      
    <?php if(!($_GET['list'] < 2)): ?>  
      <li class="page-item">
        <a class="page-link" href="/?list=<?= $_GET['list']-1 ?>"><?= $_GET['list']-1 ?></a>
      </li>
    <?php endif ?>

    <li class="page-item active">
      <a class="page-link" href="/?list=<?= $_GET['list'] ?>"><?= $_GET['list'] ?></a>
    </li>

    <?php if(!($_GET['list']+1 > $usersCount['count(*)'] / $PageCount)): ?>
      <li class="page-item">
        <a class="page-link" href="/?list=<?= $_GET['list']+1 ?>"><?= $_GET['list']+1 ?></a>
      </li>
    <?php endif ?>

    <?php if(!($_GET['list']+2 > $usersCount['count(*)'] / $PageCount)): ?>
      <li class="page-item">
        <a class="page-link" href="/?list=<?= $_GET['list']+1 ?>"><?= $_GET['list']+2 ?></a>
      </li>
    <?php endif ?>

    <li class="page-item">
        <a class="page-link" href="/?list=<?= $_GET['list']+1 ?>">>></a>
    </li>

    <li class="page-item">
      <a class="page-link" href="/?list=<?= ceil($usersCount['count(*)'] / $PageCount) ?>">
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
      $stmt = Connection()->query('SELECT IdUser, Login, Password, Email, Phone, Role FROM Users 
      INNER JOIN Roles ON Users.IdRole = Roles.IdRole 
      WHERE DeleteAt IS NULL LIMIT '.(($_GET['list']-1)*$PageCount).','.$PageCount.';');

      echo "<table class='table table-striped'><tr><th>Id</th><th>Login</th>
      <th>Email</th><th>Phone</th><th>Role</th></tr>";
      while ($row = $stmt->fetch())
      {
        echo "<tr>";
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