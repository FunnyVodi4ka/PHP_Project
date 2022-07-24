<!DOCTYPE HTML PUBLIC "-//W3C//DTD   HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Edit Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<p><a href="http://localhost/courses" class="btn btn-primary">Назад</a></p>
<div class="divcenter">
    <h2>Изменение курса в БД</h2>
    <form method="post" action="http://localhost/courses/tryedit">
        <p><b>Id курса:</b>
            <input name="idCourseForEdit" type="text" <?php echo "value=".(int)$_POST['idCourseForEdit']; ?> readonly>
        </p>
        <p><b>Введите название:</b><br>
            <input name="EditFormCourse" type="text" size="50" value="<?= $_SESSION['customCourse'] ?? $_POST['course']?>" required>
        </p>
        <p><b>Введите Id автора:</b><br>
            <input name="EditFormAuthor" type="number" value="<?= $_SESSION['customAuthor'] ?? $_POST['author']?>" required>
        </p>
        <p><b>Содержание:</b><br>
            <textarea rows="6" cols="54" name="EditFormContent"><?= $_SESSION['customContent'] ?? $_POST['content']?></textarea>
        </p>
        <input type="submit" class="btn btn-outline-warning" value="Изменить курс">
        <input type="reset" class="btn btn-outline-danger" value="Очистить"></p>
    </form>
</div>
<div>
</body>
</html>