<?php
$config = [
    'db_engine' => 'mysql',
    'db_host' => '127.0.0.1',
    'db_port' => '3306',
    'db_name' => 'ScambioInsegnamenti ',
    'db_user' => 'root',
    'db_password' => '',
];
$db_config = $config['db_engine']
    .':host='.$config['db_host']
    .":".$config['db_port']
    .";dbname="
    .$config['db_name'];
$pdo = null;
try{
    $pdo = new PDO($db_config);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    exit("Impossibile connettersi al database: " . $e->getMessage());
}