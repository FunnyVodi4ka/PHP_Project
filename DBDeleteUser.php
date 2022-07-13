<?php
    require_once('ConnectionValidation.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Результат операции</title>    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
  <meta http-equiv="refresh" content="0;URL=http://localhost/index2.php"/>
 </head>
 <body>
    <p><a href="index2.php" class="btn btn-primary">Назад</a></p>
    <?php
    session_start();
    if($_SESSION["is_role"] == 1 && $_SESSION['is_auth'] == true){
        $now_iduser = (int)$_POST['iduser'];
        if($now_iduser != $_SESSION['is_userid']){
            if(CheckIdUser($now_iduser)){
                $stmt = Connection()->prepare('UPDATE Users SET DeleteAt = NOW() WHERE IdUser = ?;');
                $stmt->execute([$now_iduser]);
                echo "Данные успешно удалены!";
            }
            else{
                echo "\nОшибка: Данн1111ые не удалены!";
            }
        }
        else{
            echo "Вы не можете удалить сами себя!";
        }
    }
    else{
        echo "Ошибка доступа, повторите попытку позже!";
    }
    ?>
 </body>
</html>