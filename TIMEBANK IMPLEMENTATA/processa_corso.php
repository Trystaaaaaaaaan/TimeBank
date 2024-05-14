<?php

global $pdo;
require 'db_connection.php';
session_start();

// verifica campi form
if (empty($_POST["materia"]) || empty($_POST["descrizione"])) {
    header("Location: crea_corso.php?error_msg=entrambi i campi sono obbligatori");
    exit();
}

if(!isset($_SESSION['user_id'])){
    header("Location: login.php?error_msg=effettua il login prima di creare un corso!");
    exit();
}

$idIns = $_SESSION['user_id'];
$sql_verifica = "
    select *
    from Insegnanti
    where ID = :id
";

$query = $pdo->prepare($sql_verifica);
$query->bindParam(":id", $idIns);
$query->execute();

$insegnanti = $query->fetchAll();



$materia = $_POST['materia'];
$descrizione = $_POST['descrizione'];
$idIns = $_SESSION['user_id'];
if(count($insegnanti) < 1) {
    $sql_salvataggio = "
        insert into Insegnanti (ID, Materie) 
        values (:idIns, :materia);
    ";

    $query = $pdo->prepare($sql_salvataggio);
    $query->bindParam(":materia", $materia);
    $query->bindParam(":idIns", $idIns);
    $query->execute();
}

$sql_salvataggio = "
    insert into Corsi (Materia, InsegnanteID, Descrizione) 
    values (:materia, :idIns , :Descrizione);
";

$query = $pdo->prepare($sql_salvataggio);
$query->bindParam(":materia", $materia);
$query->bindParam(":idIns", $idIns);
$query->bindParam(":Descrizione", $descrizione);
$query->execute();

$sql_verifica = "
    select ID
    from Corsi as C
    where InsegnanteID = :idIns and C.Materia = :materia and C.Descrizione = :Descrizione;
";

$query = $pdo->prepare($sql_verifica);
$query->bindParam(":materia", $materia);
$query->bindParam(":idIns", $idIns);
$query->bindParam(":Descrizione", $descrizione);
$query->execute();

$corsoID = $query->fetchAll();

if ($query->rowCount() > 0) {
    header("location: corso.php?id=".$corsoID[0]['ID']); // utente creato

} else {
    header("location: registrazione.php?error_msg=Errore interno nel salvataggio"); // errore nel salvataggio
}