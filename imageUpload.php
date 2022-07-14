<?php
$target_dir = "userImages/";
$parts = pathinfo($_FILES['imageUserEditer']['name']);
$target_file = $target_dir . basename(mt_rand().$_FILES["imageUserEditer"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["imageUserEditer"])) {
    $check = getimagesize($_FILES["imageUserEditer"]["tmp_name"]);
    if($check !== false) {
      $uploadOk = 1;
    } else {
        alertMessage("Этот файл не изображение.");
      $uploadOk = 0;
    }
  }
  
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    alertMessage("К сожалению, разрешены только файлы JPG, JPEG, PNG и GIF.");
    $uploadOk = 0;
  }
  elseif (file_exists($target_file)) {
    alertMessage("Извините, файл уже существует.");
    $uploadOk = 0;
  }
  elseif ($_FILES["imageUserEditer"]["size"] > 500000) {
    alertMessage("Извините, ваш файл слишком большой.");
    $uploadOk = 0;
  }
  
  if ($uploadOk == 0) {
    alertMessage("Извините, ваш файл не был загружен.");
  } 
  else {
    if (move_uploaded_file($_FILES["imageUserEditer"]["tmp_name"], $target_file)) {
      echo "<p>Файл ". htmlspecialchars( basename( $_FILES["imageUserEditer"]["name"])). " был загружен.</p>";
      require_once('ConnectionValidation.php');
        
      $stmt = Connection()->prepare('SELECT AvatarImage FROM Users WHERE IdUser = ?');
      $stmt->execute([$now_iduser]);
      while ($row = $stmt->fetch())
        {
            if(!empty($row["AvatarImage"])){
                unlink($row["AvatarImage"]);
            }
        }

      $stmt = Connection()->prepare('UPDATE Users SET AvatarImage = ? WHERE IdUser = ?');
      $stmt->execute([$target_file, $now_iduser]);
    } else {
        alertMessage("Извините, произошла ошибка при загрузке вашего файла.");
    }
  }
?>