<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <title>Réussi!</title>
        <meta charset="utf-8">
        <link href="../css/index.css" rel="stylesheet">
    </head>
    <body>
        <?php
        if(isset($_SESSION['compte'])) {
            if(isset($_SESSION['role']) == 'Admin') {
                ?>
                <h1>Accès Autorisé!</h1>
                <?php
            } else {
                ?>
                <h1>Accès Interdit!</h1>
                <h2>Vous n'avez pas les droits d'administrateur!</h2>
                <?php
            }
        } else {
            header("Location: ../");
        }
        ?>
    </body>
</html>