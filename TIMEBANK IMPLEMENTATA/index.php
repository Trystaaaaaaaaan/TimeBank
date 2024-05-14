
<?php
$error_msg = $_GET['error_msg'] ?? "";

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIMEBANK</title>
</head>
<body>
<?php include 'header.php'?>
            
            <div class="imgPrincipale">
                <img src="immagine/copertina.png" alt="Logo TIMEBANK">
            </div>

    <main>
        <section class="courses">
            <a href="corso.php?id=246">
            <div class="course">
                <img src="immagine/Matematica.jpeg" alt="Miniatura del corso di Matematica">
                <h3>Matematica</h3>
                <p>Giorgio Vanni</p>
            </div>
            </a>
            <div class="course">
                <img src="immagine/Italiano.webp" alt="Miniatura del corso di Italiano">
                <h3>Italiano</h3>
                <p>Rosario Muniz</p>
            </div>
            <div class="course">
                <img src="immagine/Fisica.jpeg" alt="Miniatura del corso di Fisica">
                <h3>Fisica</h3>
                <p>Illac</p>
            </div>
        </section>
    </main>
    <script src="script.js"></script>
    <?php include 'footer.html'?>
</body>
</html>

