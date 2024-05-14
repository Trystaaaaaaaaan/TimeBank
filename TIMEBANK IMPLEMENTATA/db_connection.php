<?php
/*
PDO = PHP Data Object
DSN = Data Source Name (tipo di db, nome host, nome del database, porta, charset)
PDO => DSN, username, password, opzioni
*/
$type = 'mysql';
$server = '127.0.0.1';
$db = 'ScambioInsegnamenti';
$port = '3306';
$charset = 'utf8mb4';

$username = 'root';
$password = '12345678';

$options = [
    PDO::ATTR_ERRMODE               =>  PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE    =>  PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES      =>  false,
];

$dsn = "$type:host=$server;dbname=$db;port=$port;charset=$charset";
$pdo = null;

try{
    $pdo = new PDO($dsn, $username, $password, $options);
}
catch(PDOException $e){
    throw new PDOException($e->getMessage(), $e->getCode());
}
?>