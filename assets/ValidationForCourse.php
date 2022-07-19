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
            echo "\n<p>Ошибка: Некорректный Id курса!</p>";
            return false;
        }
    }
    function CheckCourse($name){
        if(!empty($name) && strlen($name) >= 5 && strlen($name) <= 255){
            return true;
        }
        else{
            echo "\n<p>Ошибка: Длина названия курса должна быть от 5 до 255 символов!</p>";
            return false;
        }
    }
    function CheckAuthor($id){
        if(!empty($id)){
            $stmt = Connection()->prepare('SELECT * FROM Users WHERE IdUser = ? AND DeleteAt IS NULL');
            $stmt->execute([$id]);
            $count = $stmt->rowCount();
            if($count == 1){
                return true;
            }
            else{
                echo "<p>Ошибка: Такого автора нет или он удалён!</p>";
                return false;
            }
        }
        else{
            echo "\n<p>Ошибка: Некорректный Id автора!</p>";
            return false;
        }
    }
    function CheckContent($content){
        if(strlen($content) <= 255){
            return true;
        }
        else{
            echo "\n<p>Ошибка: Длина содержания курса должна быть 255 символов!</p>";
            return false;
        }
    }