<?php
session_start();
if ($_SESSION["is_auth"] && $_SESSION["is_role"] == 1): 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Welcome to CRUD</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="../../css/style.css">
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
      <p><a class="btn btn-info" width="100 " href="PageTableCourses">Таблица "Курсы"</a></p>
    </div>
 </body>
</html>
<?php else: 
    header("Refresh:0; url=auth");
    die();
endif; ?>