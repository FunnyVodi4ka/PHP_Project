<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Данные о курсе</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<div>
<?php
//session_start();
//if($_SESSION["is_role"] == 1) {
//    echo '<b><a href="http://localhost/courses/catalog" class="btn btn-primary">Назад</a></b>';
//} else {
//    echo '<b><a href="http://localhost/courses" class="btn btn-primary">Назад</a></b>';
//}
echo '<b><a href="http://localhost/courses/catalog" class="btn btn-primary">Назад</a></b>';
while ($row = $stmt->fetch())
{
    echo "<h2>Данные о курсе с Id: ".$row["course_id"]."</h2>";
    echo "<p><b>Статус курса: </b>";
    if(empty($row["deleted_at"])){
        echo "<b class='statusTextActive'>Active</b></p>";
    }
    else{
        echo "<b class='statusTextDeleted'>Deleted</b></p>";
    }
    echo "<p><b>Название курса:</b> ".$row["course_name"]."</p>";
    echo "<p><b>Автор:</b> ".$row["login"]."</p>";
    $nowContentData = json_decode($row["content"]);
    echo "<p><b>Содержание:</b></p><p>".$nowContentData."</p>";
}
?>
</div>
</body>
</html>
