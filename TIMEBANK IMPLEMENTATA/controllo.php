<?php

// Connessione al database
$servername = "127.0.0.1"; // Nome del server
$username = "username"; // Nome utente del database
$password = "password"; // Password del database
$dbname = "ScambioInsegnamenti"; // Nome del database

// Crea la connessione
$conn = mysqli_connect($servername, $username, $password, $dbname, 3306);

// Verifica la connessione
if (!$conn) {
    die("Connessione al database fallita: " . mysqli_connect_error());
}

// Aggiorna il punteggio di un utente
$userID = 1; // ID dell'utente da aggiornare
$newPoints = 100; // Nuovo punteggio
$sql = "UPDATE Utenti SET Punti = $newPoints WHERE ID = $userID";
mysqli_query($conn, $sql);
