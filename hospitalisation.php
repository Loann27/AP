<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <title>hospitalisation</title>
        <meta charset="utf-8">
        <link href="../../css/index.css" rel="stylesheet">
    </head>
    <body>
        <?php
        if(isset($_SESSION['compte'])) {
            if($_SESSION['role'] == 'Secrétaire') {
                ?>
                <p id="affichage"></p>
                <div class="centre">
                    <a href="./accueil_secretaire.php"><input type='submit' value='RETOUR'></a>
                </div>
                <?php
            } else {
                ?>
                <div class="bloc">
                    <div class="item2">
                        <img src="../../images/cadenas.jpg" height="50%" width="20%"><br>
                        <h1>Accès Interdit!</h1><br>
                        <p>Vous n'êtes pas secrétaire!</p>
                    </div>
                </div>
                <?php
            }
        } else {
            header('Location: ../../');
        }
        ?>
        <script src="../../js/variables.js"></script>
    </body>
