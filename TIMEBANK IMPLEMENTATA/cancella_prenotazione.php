<?php
global $pdo;
require 'db_connection.php';
session_start();

$sql_verifica = "
    delete from Prenotazioni where UtenteID = :idUtente and CorsoID = :idCorso
";

$query = $pdo->prepare($sql_verifica);
$query->bindParam(":idUtente", $_SESSION['user_id']);
$query->bindParam(":idCorso", $_GET['corso_id']);
$query->execute();

header('Location: corso.php?id='.$_GET['corso_id']);
