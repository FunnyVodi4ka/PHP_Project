<?php
while ($row = $stmt->fetch())
        {
            echo "<p><b>Статус курса: </b>";
            if(empty($row["DeleteAt"])){
                echo "<b class='statusTextActive'>Active</b></p>";
            }
            else{
                echo "<b class='statusTextDeleted'>Deleted</b></p>";
            }
            echo "<p><b>Название курса:</b> ".$row["Course"]."</p>";
            echo "<p><b>Автор:</b> ".$row["Login"]."</p>";
            $nowContentData = json_decode($row["Content"]);
            echo "<p><b>Содержание:</b></p><p>".$nowContentData."</p>";
        }