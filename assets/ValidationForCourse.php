<?php
    function CheckIdCourse($id){
        if(!empty($id)){
            $stmt = Connection()->prepare('SELECT * FROM Courses WHERE IdCourse = ?');
            $stmt->execute([$id]);
            $count = $stmt->rowCount();
            if($count == 1){
                return true;
            }
            else{
                echo "<p>Ошибка: Такого курса нет!</p>";
                return false;
            }
        }
        else{
            echo "\n<p>Ошибка: Некорректный Id курса!</p>";
            return false;
        }
    }
    function CheckCourse($course){
        if(!empty($course) && strlen($course) >= 5 && strlen($course) <= 255){
            if (preg_match("/^[a-zA-Z0-9\!\.\,\[\]\=\<\>\?\s*_-]{5,255}$/i", $course)) {
                return true;
            }
            else{
                echo "<p>Ошибка: В названии разрешены только цифры и латинские буквы, а также стандартные знаки препинания!</p>";
                return false;
            }
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
            if (preg_match("/^[a-zA-Z0-9\!\.\,\[\]\=\<\>]?\s*_-]{5,255}$/i", $content)) {
                return true;
            }
            else{
                echo "<p>Ошибка: В содержании разрешены только цифры, русские и латинские буквы, а также стандартные знаки препинания!</p>";
                return false;
            }
        }
        else{
            echo "\n<p>Ошибка: Длина содержания курса должна быть 255 символов!</p>";
            return false;
        }
    }