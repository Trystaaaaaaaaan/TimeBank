<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Registrazione</title>

</head>
<body>
<?php
// Verifica se l'utente è già loggato


if (isset($_SESSION['id'])) {
    echo '<p>Benvenuto! Sei già loggato.</p>';
} else {
    if(!empty($_GET['error']))
        echo '<p color="red">Ricontrollare i campi e riprovare!</p>';
    // Mostra il form di login/registrazione
    echo '
        <h1>Login/Registrazione</h1>
        <form action="process_login.php" method="post">
            <input type="text" id="name" name="name" required placeholder="Nome e Cognome">
            <br>
            <input type="email" id="email" name="email" required placeholder="Email">
            <br>
            <input type="password" id="password" name="password" required placeholder="Password">
            <br>
            <input type="submit" value="Accedi">
            <br>
            
            <a href="registrazione.php">Registrati</a>
        </form>
        ';
}
?>
</body>
</html>
