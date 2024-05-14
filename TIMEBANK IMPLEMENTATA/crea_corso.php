<?php
include 'header.php';
$error_msg = $_GET['error_msg'] ?? "";
//controlla se la session è settata, senno porta al login

if(!isset($_SESSION['user_id'])){
    header("location: login.php?error_msg=Non hai effettuato il login");
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <form action="processa_corso.php" method="POST">

        <input type="text" id="materia" name="materia" placeholder="materia" required >
        <br>
        <input type="text" id="descrizione" name="descrizione" placeholder="descrizione" required>
        <br>
        <input type="submit" value="Crea">

    </form>

</body>
</html>
