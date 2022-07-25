<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Create Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<p><a href="http://localhost/courses" class="btn btn-primary">Назад</a></p>
<div class="divcenter">
    <h2>Добавление курса в БД</h2>
    <form method="post" action="http://localhost/courses/trycreate">
        <p><b>Введите название:</b><br>
            <input name="CreateFormCourse" type="text" size="50" value="<?= $_SESSION['customCourse'] ?? '' ?>" required>
        </p>
        <p><b>Введите Id автора:</b><br>
            <input name="CreateFormAuthor" type="number" value="<?= $_SESSION['customAuthor'] ?? '' ?>" required>
        </p>
        <p><b>Содержание:</b><br>
            <textarea rows="6" cols="54" name="CreateFormContent"><?= $_SESSION['customContent'] ?? '' ?></textarea>
        </p>
        <input type="submit" class="btn btn-outline-success" value="Добавить курс">
        <input type="reset" class="btn btn-outline-danger" value="Очистить"></p>
    </form>
</div>
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
</body>
</html>