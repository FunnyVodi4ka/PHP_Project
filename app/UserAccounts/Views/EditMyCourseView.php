<!DOCTYPE HTML PUBLIC "-//W3C//DTD   HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Редактирование курса</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<p><a href="http://localhost/courses" class="btn btn-primary">Назад</a></p>
<div class="divcenter">
    <h2>Изменение курса в БД</h2>
    <form method="post" action="http://localhost/courses/tryupdate">
        <p><b>Id курса:</b>
            <input name="idCourseForEdit" type="text" <?php echo "value=".(int)$_POST['idCourseForEdit']; ?> readonly>
        </p>
        <p><b>Введите название:</b><br>
            <input name="EditFormCourse" type="text" size="50" value="<?= $_SESSION['customCourse'] ?? $_POST['course']?>" required>
        </p>
        <input type="submit" class="btn btn-outline-warning" value="Изменить курс">
        <input type="reset" class="btn btn-outline-danger" value="Очистить"></p>
    </form>
    <?php
    if(!empty($_SESSION['errorArray'])) {
        echo "<div class='divcenter'>";
        echo "<div class='errorbox'>";
        foreach ($_SESSION['errorArray'] as $row) {
            echo "<p>" . $row . "</p>";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
    <h2>Добавление нового элемента</h2>
    <form method="post" action="http://localhost/courses/<?=$_POST['idCourseForEdit']?>/update">
        <p><b>Тип элемента:</b>
        <select name="addType" class="form-select" method="post">
            <option class="optionC" value="Article">Текст</option>
            <option class="optionC" value="linkToVideo">Ссылка на видео</option>
            <option class="optionC" value="linkToAudio">Ссылка на аудиофайл</option>
        </select>
        </p>
        <p><textarea rows="4" cols="45" name="addContent"></textarea></p>
        <input name="btnAddElement" type="submit" class="btn btn-outline-success" value="ADD">
    </form>
<?php
echo "<div class='BigBox'>";
$i = 0;
foreach ($_POST['content'] as $obj) {
    echo "<div class='bigcontentbox'><div class='contentbox'>";
    echo '<form method="post" action="http://localhost/courses/'.$_POST['idCourseForEdit'].'/update">';
    echo '<input name="ElementId" type="number" size="5" value="'.$i.'" hidden>';
    echo '<p><select name="updateType" class="form-select">';
    if($obj["type"] == "Article")
        echo '<option selected class="optionC" value="Article">Текст</option>';
    else
        echo '<option class="optionC" value="Article">Текст</option>';
    if($obj["type"] == "linkToVideo")
        echo '<option selected class="optionC" value="linkToVideo">Ссылка на видео</option>';
    else
        echo '<option class="optionC" value="linkToVideo">Ссылка на видео</option>';
    if($obj["type"] == "linkToAudio")
        echo '<option selected class="optionC" value="linkToAudio">Ссылка на аудиофайл</option>';
    else
        echo '<option class="optionC" value="linkToAudio">Ссылка на аудиофайл</option>';
    echo '</select></p>';
    echo '<p><textarea rows="4" cols="45" name="updateContent">'.$obj['content'].'</textarea></p>';
    echo '<input name="btnUpdateElement" type="submit" class="btn btn-outline-warning" value="Изменить элемент"/>';
    echo '<input name="btnDeleteElement" type="submit" class="btn btn-outline-danger" value="Удалить элемент"/>';
    echo '</form>';
    echo "</div></div>";
    $i++;
}
echo "</div></div>";
?>
</body>
</html>