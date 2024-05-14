<?php
require('db_connection.php');
global $pdo;
session_start();

$sql = "SELECT ID, mail, password FROM Utenti WHERE id = :id";

$query = $pdo->prepare($sql);
$query->bindParam(':id', $_SESSION["user_id"], PDO::PARAM_STR);
$query->execute();

$res = $query->fetch();
$li = "<li><a href='login.php'><img src='immagine/utente.png' alt='Icona utente' class='png'></a></li>";
if($res != null)
    $li = "<li><a href='utente.php'><img src='immagine/utente.png' alt='Icona utente' class='png'></a></li>";

?>
<header>
    <nav>
        <ul>

            <li><a href="#">Chi siamo</a></li>
            <li><a href="corsi.php">Corsi</a></li>
            <li><a href="crea_corso.php">crea corso</a></li>

            <li><a href="#"><img src="immagine/lente.png" alt="Icona di ricerca" class="png"></a></li>
            <?= $li ?>
            <?= '<a href="log_out.php">logout</a>' ?>

        </ul>
    </nav>

</header>
<link rel="stylesheet" href="style.css">
