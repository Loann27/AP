<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <title>patient</title>
        <meta charset="utf-8">
        <link href="../../css/index.css" rel="stylesheet">
    </head>
    <header>
        <script src="https://cdn.jsdelivr.net/gh/noumanqamar450/alertbox@main/version/1.0.2/alertbox.min.js"></script>
    </header>
    <body>
        <?php
        if(isset($_SESSION['compte'])) {
            if($_SESSION['role'] == 'Secrétaire') {
                ?>
                <img src="../../images/Patient.png">
                <div id="bloc1">
                    <form method="POST" action="patient.php">
                        <label for="civ">Civ. </label>
                        <select name="civ" id="civ" required>
                            <option value="">Choix</option>
                            <option value="Homme">Homme</option>
                            <option value="Femme">Femme</option>
                        </select>
                        <label for="nom_naissance">Nom de naissance </label>
                        <input id="nom_naissance" name="nom_naissance" type="text" required>
                        <label for="nom_epouse">Nom d'épouse </label>
                        <input id="nom_epouse" name="nom_epouse" type="text"><br><br>
                        <label for="prenom">Prénom </label>
                        <input type="text" id="prenom" name="prenom" required>
                        <label for="date_naissance">Date de naissance </label>
                        <input type="date" id="date_naissance" name="date_naissance" required><br><br>
                        <label for="adresse">Adresse </label>
                        <input type="text" id="adresse" name="adresse" required><br><br>
                        <label for="cp">Code Postal </label>
                        <input type="text" id="cp" name="cp" required>
                        <label for="ville">Ville </label>
                        <input type="text" id="ville" name="ville" required><br><br>
                        <label for="email">Email </label>
                        <input type="mail" id="email" name="email" required>
                        <label for="telephone">Téléphone </label>
                        <input type="tel" id="telephone" name="telephone" min="10" max="10" required><br><br>
                        <input type="submit" id="submit" name="submit" value="Suivant >">
                    </form>
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
</html>