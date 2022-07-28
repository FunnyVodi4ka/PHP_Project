<?php
function Connection(){
    try {
    $host = 'localhost';
    $db   = 'CrudDatabase';
    $user = 'root';
    $pass = 'Password_12345';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);
    return $pdo;
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage() . "<br/>";
        die();
    }
}