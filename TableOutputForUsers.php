<?php
    require_once('ConnectionValidation.php');
    $stmt = Connection()->query('SELECT IdUser, Login, Password, Email, Phone, Role FROM Users 
    INNER JOIN Roles ON Users.IdRole = Roles.IdRole 
    WHERE DeleteAt IS NULL ORDER BY IdUser DESC LIMIT '.(($_GET['list']-1)*$PageCount).','.$PageCount.';');

    echo "<table class='table table-striped'><tr><th>Id</th><th>Login</th>
    <th>Email</th><th>Phone</th><th>Role</th></tr>";
    while ($row = $stmt->fetch())
    {
    echo "<tr>";
    echo "<td>" . $row["IdUser"] . "</td>";
    echo "<td>" . $row["Login"] . "</td>";
    echo "<td>" . $row["Email"] . "</td>";
    echo "<td>" . $row["Phone"] . "</td>";
    echo "<td>" . $row["Role"] . "</td>";
    echo "</tr>";
    }
    echo "</table>";
?>