<!DOCTYPE HTML PUBLIC "-//W3C//DTD   HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">
    <script>
        function deleteName(f) {
            if (confirm("Вы уверены, что хотите удалить запись?")){
                f.submit();
            }
        }
        function recoverName(f) {
            if (confirm("Вы уверены, что хотите восстановить запись?")){
                f.submit();
            }
        }
    </script>
</head>
<body>
<div class="exit">
    <b>
        <a class="btn btn-primary" href="http://localhost/LogOut" onclick="return  confirm('Вы точно хотите выйти?')">Выход</a>
        <a class="btn btn-primary" href="http://localhost/adminpanel">Назад</a>
    </b>
    <b>Добрый день, Администратор!</b>
</div>
<h2>Список курсов</h2>
<?php
 //require_once('../assets/pagination.php');
?>
<a href="http://localhost/courses/create" class='btn btn-outline-success'>Создать запись</a>
<table class='table table-striped'>
    <tr>
        <th></th>
        <th>Id</th>
        <th>Course</th>
        <th>Author</th>
        <th>Deleted At</th>
        <th></th>
        <th></th>
    </tr>
    <?php
    while ($row = $stmt->fetch())
    {
        if(!empty($row['deleted_at'])){
            echo "<tr class='deletedRow'>";
        } else {
        echo "<tr>";
        }
        echo "<td><a class='btn btn-outline-secondary' href='http://localhost/courses/".$row["course_id"]."/view'>Просмотр</a></td>";

        echo "<td>" . $row["course_id"] . "</td>";
        echo "<td>" . $row["course_name"] . "</td>";
        echo "<td>" . $row["author_id"] . "</td>";
        echo "<td>" . $row["deleted_at"] . "</td>";

        if(!empty($row['deleted_at'])){
        echo "<td colspan='2'><a class='btn btn-outline-secondary' href='http://localhost/courses/".$row["course_id"]."/recover'>Восстановить</a></td>";
        }
        else{
        echo "<td><a class='btn btn-outline-warning' href='http://localhost/courses/".$row["course_id"]."/edit'>Редактировать</a></td>";

        echo "<td><a class='btn btn-outline-danger' href='http://localhost/courses/".$row["course_id"]."/delete'>Удалить</a></td>";
        }
        echo "</tr>";
    }
    ?>
    </table>
</body>
</html>