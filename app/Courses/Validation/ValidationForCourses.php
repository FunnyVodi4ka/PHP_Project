<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/app/Courses/Models/CourseModel.php');

class ValidationForCourses
{
    public function alertMessage($message) {
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    public function CheckCourseId($id)
    {
        $model = new CourseModel();
        $count = $model->SearchCourseId($id);
        if($count > 0){
            return true;
        } else {
            $this->alertMessage("Ошибка: Некорректный id!");
            return false;
        }
    }

    public function CheckCourseName(string $name)
    {
        if(!empty($name) && strlen($name) >= 5 && strlen($name) <= 255){
            if (preg_match("/^[a-zA-Z0-9\!\.\,\[\]\=\<\>\?\s*_-]{5,255}$/i", $name)) {
                return true;
            } else {
                $this->alertMessage("Ошибка: В названии разрешены только цифры и латинские буквы, а также стандартные знаки препинания!");
                return false;
            }
        } else {
            $this->alertMessage("Ошибка: Длина названия курса должна быть от 5 до 255 символов!");
            return false;
        }
    }
    public function CheckAuthor(int $id)
    {
        $model = new CourseModel();
        $count = $model->SearchAuthor($id);
        if($count == 0) {
            $this->alertMessage("Ошибка: Такого пользователя не существует!");
            return false;
        } else {
            return true;
        }
    }
    public function CheckContent(string $content)
    {
        if(strlen($content) <= 255 && strlen($content) >= 5){
            if (preg_match("/^[a-zA-Z0-9\!\.\,\[\]\=\<\>\?\s*_-]{5,255}$/i", $content)) {
                return true;
            } else {
                $this->alertMessage("Ошибка: В содержании разрешены только цифры и латинские буквы!");
                return false;
            }
        } else {
            $this->alertMessage("Ошибка: Длина содержания курса должна быть 255 символов!");
            return false;
        }
    }
}