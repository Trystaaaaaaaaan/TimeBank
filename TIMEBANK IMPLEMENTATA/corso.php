<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Information</title>
<?php
include 'header.php';
?>
</head>
<body>

<?php
    require "db_connection.php";
    global $pdo;
    $msg = "";
    if (!empty($_GET['success_msg']))
        $msg = "prenotazione effettuata con successo";
    if (!empty($_GET['error_msg']))
        $msg = "prenotazione fallita! ritenta! Ricorda che se non hai punti non potrai effettuarla";
    echo '<p color="red"> '.$msg.'</p>';
    // Assume the course name is passed via URL parameter (e.g., ?course=Introduction%20to%20Database%20Management)
    if (!empty($_GET['id'])) {
        $selectedCourse = $_GET['id'];
        $sql = 'SELECT Materia, Descrizione, U.Nome FROM Corsi C
                    JOIN Insegnanti I ON C.InsegnanteID = I.ID
                    JOIN Utenti U on I.ID = U.ID
                    WHERE C.ID = :course';

        $query = $pdo->prepare($sql);
        $query->bindParam(':course', $selectedCourse, PDO::PARAM_STR);
        $query->execute();

        $corso = $query->fetch();

        if ($corso != null) {
            echo "<p><strong>Course Name:</strong> " . $corso["Materia"] . "</p>";
            echo "<p><strong>Course Description:</strong> " . $corso["Descrizione"] . "</p>";
            echo "<p><strong>Instructor:</strong> " . $corso["Nome"] . "</p>";
            // verifica presenza di prenotazione
            $sql_verifica1 = '
                select *
                from Prenotazioni as P
                join Utenti U on P.UtenteID = U.ID
                where P.UtenteID = :idUtente and P.corsoId = :idCorso';
            $idUtente = $_SESSION['user_id'];
            $idCorso = $_GET['id'];
            $query = $pdo->prepare($sql_verifica1);
            $query->bindParam(":idUtente", $idUtente);
            $query->bindParam(":idCorso", $idCorso);
            $query->execute();
            //verifica che l'utente attuale non sia l'insegnante che ha postato il corso
            $sql_verifica2 = '
                select *
                from Prenotazioni as P
                join Corsi as C on P.CorsoID = C.ID
                where C.InsegnanteID = :insegnanteID and C.ID = :idCorso;
            ';
            $query2 = $pdo->prepare($sql_verifica2);
            $query2->bindParam(":insegnanteID", $idUtente);
            $query2->bindParam(":idCorso", $idCorso);
            $query2->execute();

            $utenti = $query->fetchAll();
            $isInsegnante = $query2->fetchAll();
            echo "fischias".count($isInsegnante);
            echo "numero prenotazioni effettuater: ".count($utenti);
            if(count($utenti) == 0 && count($isInsegnante) == 0) {
                echo '<form action="processa_prenotazione.php" method="get">
                      <input type="hidden" name="corso_id" value="' . $idCorso . '">
                      <input type="submit" value="Prenota">
                    </form>';
                exit();
            }else{
                echo '<form action="cancella_prenotazione.php" method="get">
                      <input type="hidden" name="corso_id" value="' . $idCorso . '">
                      <input type="submit" value="Disiscriviti">
                    </form>';
                exit();
            }

        } else {
            echo "<p>Nessun risultato trovato per il corso selezionato</p>";
        }
    }
    ?>

</body>
</html>
