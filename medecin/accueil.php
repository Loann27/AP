<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <title>Accueil médecin</title>
        <meta charset="utf-8">
        <link href="../../css/index.css" rel="stylesheet">
        <script>
            function redirection() {
                window.location.href = "planning.php";
            }
        </script>
    </head>
    <body>
        <?php
        if(isset($_SESSION['compte'])) {
            if(($_SESSION['role'] == 'Admin') || ($_SESSION['role'] == 'Médecin') || ($_SESSION['role'] == 'Chirurgien')) {
                ?>
                <div class="items1">
                    <h1>Les rendez vous</h1>
                    <input type="image" onclick="redirection()" src="../../images/formulaire.png" height="70%" width="25%" alt="Rendez-vous">
                </div>
                <?php
            } else {
                ?>
                <h1>Accès interdit!</h1>
                <h2>Vous n'êtes pas autorisé à être ici!</h2>
                <?php
            }
        } else {
            header('Location: ../../');
        }
        ?>
    </body>
</html>
