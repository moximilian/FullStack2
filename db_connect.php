<?php
$db_file = './database.db';

try{
    $pdo = new PDO("sqlite:$db_file");
    $pdo->setAttribute(PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
}
catch(PDOException $e){
    echo "Connection failed:".$e->getMessage();
}
?>