<?php
global $pdo;
require 'db_connection.php';

session_start();
// verifica campi form
if(empty($_SESSION['user_id']) || empty($_GET['corso_id'])) {
    header("location: corso.php?error_msg=errore"); // redirect
//    http_redirect("signup.php");
    exit();
}

$utente_id = $_SESSION['user_id'];
$corso_id = $_GET['corso_id'];




$sql_verifica = "
    select *
    from Prenotazioni
    where UtenteID = :uID and CorsoID = :cID
";

$query = $pdo->prepare($sql_verifica);
$query->bindParam(":uID", $utente_id);
$query->bindParam(":cID", $corso_id);
$query->execute();

$utenti = $query->fetchAll();

if(count($utenti) > 0) {
    // ho trovato una corrispondenza -> username già utilizzato
    header("location: corso.php?id=".$_GET['corso_id']); // redirect
    exit();
}

$sql_verificaPti = "
    select punti
    from Utenti
    where ID = :uID
";

$query = $pdo->prepare($sql_verificaPti);
$query->bindParam(":uID", $utente_id);
$query->execute();

$utenti = $query->fetch();
if($utenti['punti'] == 0) {
    // controllo se non ha abbastanza punti
    header("location: corso.php?id=".$_GET['corso_id']."&error_msg=1"); // redirect
    exit();
}



$sql_salvataggio = '
    insert into Prenotazioni (UtenteID, CorsoID) values (:uID, :cID);
';

$query = $pdo->prepare($sql_salvataggio);
$query->bindParam(":uID", $utente_id);
$query->bindParam(":cID", $corso_id);
$query->execute();


if ($query->rowCount() > 0) {
    header("location: corso.php?id=".$corso_id."&success_msg=successo"); // prenotazione creata

} else {
    header("location: registrazione.php?error_msg=Errore nella crezione della prenotazione "); // errore nella creazione
}
