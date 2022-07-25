<?php
class ImageUpload
{
public function alertMessage($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
}

public function Upload(int $now_iduser)
{
    $target_dir = "/public/userImages/";
    $parts = pathinfo($_FILES['imageUserEditer']['name']);
    $target_file = $target_dir . basename(mt_rand() . $_FILES["imageUserEditer"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_FILES["imageUserEditer"])) {
        $check = getimagesize($_FILES["imageUserEditer"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            alertMessage("Этот файл не изображение.");
            $uploadOk = 0;
        }
    }


    if (mime_content_type($_FILES['imageUserEditer']['tmp_name']) != 'image/jpeg'
        && mime_content_type($_FILES['imageUserEditer']['tmp_name']) != 'image/jpg'
        && mime_content_type($_FILES['imageUserEditer']['tmp_name']) != 'image/png') {
        $uploadOk = 0;
        alertMessage("К сожалению, разрешены только файлы JPG, JPEG и PNG.");
    } elseif (file_exists($target_file)) {
        alertMessage("Извините, файл уже существует.");
        $uploadOk = 0;
    } elseif ($_FILES["imageUserEditer"]["size"] > 500000) {
        alertMessage("Извините, ваш файл слишком большой.");
        $uploadOk = 0;
    }

    if ($uploadOk != 0) {
        if (move_uploaded_file($_FILES["imageUserEditer"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
            echo "<p>Файл " . htmlspecialchars(basename($_FILES["imageUserEditer"]["name"])) . " был загружен.</p>";
            require_once($_SERVER['DOCUMENT_ROOT'] . '/config/database.php');

            $stmt = Connection()->prepare('SELECT avatar_image FROM users WHERE user_id = ?');
            $stmt->execute([$now_iduser]);
            while ($row = $stmt->fetch()) {
                if (!empty($row["avatar_image"])) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . $row["avatar_image"]);
                }
            }

            $stmt = Connection()->prepare('UPDATE users SET avatar_image = ? WHERE user_id = ?');
            $stmt->execute([$target_file, $now_iduser]);
        } else {
            alertMessage("Извините, произошла ошибка при загрузке вашего файла.");
        }
    }
}
}