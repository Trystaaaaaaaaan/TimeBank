<?php

if(isset($_GET['error_msg'])) {
    $error_msg = $_GET['error_msg'];
} else {
    $error_msg = "";
}

global $pdo;
require 'db_connection.php';

// verifica campi form
if(empty($_POST['email']) || empty($_POST['password']) || empty($_POST['name'])) {
    header("location: registrazione.php <?error_msg=Verifica campi form"); // redirect
//    http_redirect("signup.php");
    exit();
}

$mail = $_POST['email'];
$password = $_POST['password'];
$name = $_POST['name'];


// verifico che l'utente non esiste già

$sql_verifica = "
    select *
    from Utenti
    where Mail = :mail
";

$query = $pdo->prepare($sql_verifica);
$query->bindParam(":mail", $mail);
$query->execute();

$utenti = $query->fetchAll();

if(count($utenti) > 0) {
    // ho trovato una corrispondenza -> username già utilizzato
    header("location: registrazione.php?error_msg=Email già in uso"); // redirect
    exit();
}

// genero l'hash della password

$password_hash = password_hash($password, PASSWORD_DEFAULT);

// salvo l'utente nel db

$sql_salvataggio = "
    insert into Utenti (Mail, password,Nome) 
    values (:mail, :psw , :name);
";

$query = $pdo->prepare($sql_salvataggio);
$query->bindParam(":mail", $mail);
$query->bindParam(":psw", $password_hash);
$query->bindParam(":name", $name);
$query->execute();


if ($query->rowCount() > 0) {
    header("location: login.php"); // utente creato

} else {
    header("location: registrazione.php?error_msg=Errore interno nel salvataggio"); // errore nel salvataggio
}

