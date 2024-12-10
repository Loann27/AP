<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <title>Accueil Secrétaire</title>
        <meta charset="utf-8">
        <link href="../../css/index.css" rel="stylesheet">
    </head>
    <body>
        <?php
        if(isset($_SESSION['compte'])) {
            if($_SESSION['role'] == 'Secrétaire') {
                ?>
                <div class="bloc">
                    <div class="item1">
                        <img src="../../images/formulaire.png" height="50%" width="20%"><br>
                        <a href="./hospitalisation.php"><input type="submit" value="Pré-Admission"></a>
                    </div>
                </div>
                <div class="deconnexion">
                    <a href="../deconnexion.php">Se déconnecter</a>
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
    </body>
</html>