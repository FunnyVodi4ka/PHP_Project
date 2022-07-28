<?php
function Connection(){
    try {
    $host = '';//Your host, For example *localhost*
    $db   = '';//Your database, For example *mydatabase*
    $user = '';//Your username, For example *root*
    $pass = '';//Your password, For example *12345*
    $charset = ''; //Your encoding, For example *utf8*

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