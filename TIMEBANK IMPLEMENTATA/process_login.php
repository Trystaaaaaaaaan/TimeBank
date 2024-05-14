<?php
// Connessione al database (da personalizzare con le tue credenziali)

if(isset($_GET['error_msg'])) {
    $error_msg = $_GET['error_msg'];
} else {
    $error_msg = "";
}


require('db_connection.php');
global $pdo;
session_start();

if(empty($_POST['email']) || empty($_POST['password']) || empty($_POST['name'])){
    header("location: login.php?error_msg=Verifica campi form"); // redirect
    exit();
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT ID, mail, password FROM Utenti WHERE mail= :email";

$query = $pdo->prepare($sql);
$query->bindParam(':email', $email, PDO::PARAM_STR);
$query->execute();

$utente = $query->fetch();
if (!$utente){
    header("location: registrazione.php?error=Utente non registrato");
    exit();
}

if (password_verify($password, $utente['password']) === false) {
    header("location: login.php?error_msg=Password errata"); // redirect
    exit();
}

$_SESSION['user_id'] = $utente['ID'];
$_SESSION['user_email'] = $utente['email'];
echo $_SESSION['user_id'];
header("location: index.php");


