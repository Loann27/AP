<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <title>Accueil Secrétaire</title>
        <meta charset="utf-8">
        <link href="../../css/index.css" rel="stylesheet">
        <script>
            function redirect() {
                window.location.href = "hospitalisation.php";
            }
            function redirect2() {
                window.location.href = "modif.php";
            }
            function redirect3() {
                window.location.href = "suppr.php";
            }
        </script>
    </head>
    <body>
        <?php
        if(isset($_SESSION['compte'])) {
            if($_SESSION['role'] == 'Secrétaire') {
                ?>
                <div class="bloc">
                    <div class="item1">
                        <h1>Pré-admission</h1>
                        <input type="image" src="../../images/formulaire.png" onclick="redirect(); return false;" alt="pré-admission" height="70%" width="25%"><br>
                    </div>
                    <div class="item1">
                        <h1>Modification</h1>
                        <input type="image" src="../../images/formulaire.png" onclick="redirect2(); return false;" alt="Modif-pré-admi" height="70%" width="25%"><br>
                    </div>
                    <div class="item1">
                        <h1>Suppresion</h1>
                        <input type="image" src="../../images/formulaire.png" onclick="redirect3(); return false;" alt="Modif-pré-admi" height="70%" width="25%"><br>
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
