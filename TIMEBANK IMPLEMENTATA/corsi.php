<!doctype html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
</head>
<body>
<?php


$sql_corsi = '
    select * from Corsi C
        join Insegnanti I on I.ID = C.InsegnanteID
        join Utenti U on U.ID = I.ID;
';

$query = $pdo->prepare($sql_corsi);
$query->execute();
$corsi = $query->fetchAll();
?>
<h1>Corsi:</h1>
    <main>
        <section class="courses">
            <?php
            foreach ($corsi as $corso){
                echo '<a href="corso.php?id='.$corso['ID'].'">
                <div class="course">
                    <img src="immagine/'.$corso['Materia'].'.jpeg" alt="Miniatura del corso di '.$corso['Materia'].'" width="150dp" height="100dp">
                    <h3>'.$corso['Materia'].'</h3>
                    <p>'.$corso['Nome'].'</p>
                </div>
            </a>';
            }
            ?>
        </section>
    </main>
</body>
</html>


