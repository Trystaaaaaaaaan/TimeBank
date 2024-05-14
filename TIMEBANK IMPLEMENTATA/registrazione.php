<?php

if(isset($_GET['error_msg'])) {
    $error_msg = $_GET['error_msg'];
} else {
    $error_msg = "";
}


?>

<!--<//?php include 'header.php'; ?>-->

<h1>Registrazione</h1>

<p style="color: red">
    <?= $error_msg ?>
</p>

<form action="registra_utente.php" method="post">

    <input type="text" name="name" id="psw" placeholder="Nome e Cognome">
    <br>
    <input type="text" name="email" id="email" placeholder="email">
    <br>
    <input type="password" name="password" id="password" placeholder="password">
    <br>

    <input type="submit" value="Registrati">
</form>


<!--</?php include 'footer.php'; ?>-->
