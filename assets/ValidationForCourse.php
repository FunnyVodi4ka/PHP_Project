<?php
    function CheckIdCourse($id){
        if(!empty($id)){
            $stmt = Connection()->prepare('SELECT * FROM Courses WHERE IdCourse = ? AND DeleteAt IS NULL');
            $stmt->execute([$id]);
            $count = $stmt->rowCount();
            if($count == 1){
                return true;
            }
            else{
                echo "<p>Ошибка: Такого курса нет или он удалён!</p>";
                return false;
            }
        }
        else{
            echo "\n<p>Ошибка: Некорректный id курса!</p>";
            return false;
        }
    }