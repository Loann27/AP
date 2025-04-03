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
            ?>
            <h1>Le compte est correct!</h1>
            <?php
            $compte = $_SESSION['compte'];
            $role = $_SESSION['role'];
            $test = $_SESSION['test'];
            echo "id_role : $test <br/>";
            echo "role : $role <br/>";
            echo "identifiant : $compte <br/>";
            ?>
            <h2>Vous êtes connecté avec ce compte:</h2>
            <?php
            
            echo "<div class ='deconnexion'>$compte</div>";
            ?>
            <h2>Le compte est:</h2>
            <?php
            echo "<div class ='deconnexion'>$role</div>";
            ?>
            <div class="deconnexion">
                <a href="./admin_accueil.php">Accueil de l'administrateur</a>
            </div>
            <div class="deconnexion">
                <a href="./deconnexion.php">Déconnexion</a>
            </div>
            <?php
        } else {
            header("Location: ../");
        }
        ?>
    </body>
</html>
