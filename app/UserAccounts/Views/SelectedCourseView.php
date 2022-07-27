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
    echo '<b><a href="http://localhost/courses" class="btn btn-primary">Назад</a></b>';
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
        $nowContentData = json_decode($row["content"], JSON_FORCE_OBJECT);
        echo "<p><b>Содержание:</b></p>";
        if(empty($nowContentData)) {
            echo "<p>Нам очень жаль, но на данный момент курс пуст!</p>";
        } else {
            foreach ($nowContentData as $obj) {
                echo "<div class='bigcontentbox'><div class='contentbox'>";
                echo "<p><b>Type: </b>".$obj["type"]."</p>";
                if($obj["type"] == "linkToVideo" || $obj["type"] == "linkToAudio") {
                    echo "<p><b>Content: </b><a href='".$obj['content']."'>".$obj['content']."</a></p>";
                } else {
                    echo "<p><b>Content: </b>".$obj['content']."</p>";
                }
                echo "</div></div>";
            }
        }
    }
    ?>
</div>
</body>
</html>