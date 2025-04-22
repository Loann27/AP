<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <title>hospitalisation</title>
        <meta charset="utf-8">
        <link href="../../css/index.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <style>
            select {
                background-color: blue;
                color: #fff;
                border: 1px solid black;
                border-radius: 5px;
                font-weight: bold;
                appearance: none;
                text-align: center;
            }

            h1 {
                color: red;
            }

            input[type="file"], input[type="date"], input[type="time"] {
                background-color: blue;
                font-weight: bold;
                color: #fff;
                border: 1px solid black;
                border-radius: 5px;
            }

            input[type="text"], input[type="tel"] {
                border: 1px solid black;
            }

        </style>
    </head>
    <body>
        <?php
        if(isset($_SESSION['compte'])) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            $serveur = "localhost";
            $utilisateur = "root";
            $motDePasse = "sio2024%";
            $nomBDD = "hopital";
            try {
                $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
                $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $table = "Professionnel";
                $donnee1 = "id";
                $donnee2 = "identifiant";
                $donnee3 = "mdp";
                $donnee5 = "nom";
                $donnee6 = "id_role";
    
                $requete = $connexion->prepare("SELECT $donnee1, $donnee2, $donnee3 FROM $table");
                $requete->execute();
                $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
            }catch (PDOException $e) {
                echo "Echec de la connexion à la base de donnée : " . $e->getMessage();
            }
            $select = "SELECT Preadmi.id AS id_preadmi, Patient.prenom AS prenom_patient, Patient.nom_naissance AS nom_patient, Professionnel.nom AS nom_medecin, Professionnel.prenom AS nom_medecin FROM Preadmi INNER JOIN Professionnel ON Professionnel.id = Preadmi.id_medecin INNER JOIN Patient ON Preadmi.id_patient = Patient.id_patient;";
            $select_res = $connexion->prepare($select);
            $select_res->execute();
            if(($_SESSION['role'] == 'Secrétaire') || ($_SESSION['role'] == "Admin")) {
                ?>
                <div id='bloc1'>
                    <h1>Formulaire Pré-Admission</h1>
                    <form id="myForm" method="POST" action="suppr.php" enctype="multipart/form-data">
                        <label for='preadmi'>Pré admission:</label><br>
                        <select name='preadmi' id='preadmi' required>
                            <option value=''>Choix</option>
                            <?php
                            if ($select_res->rowCount() > 0) {
                                while ($row = $select_res->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="' . $row['id_preadmi'] . '">' . $row['prenom_patient'] . ' ' . $row['nom_patient'] . ' avec ' . $row['prenom_medecin'] . $row['nom_medecin'] . '</option>';
                                }
                            } else {
                                echo '<option value="">Aucune pré admission disponible!</option>';
                            }
                            ?>
                        </select><br><br>
                        <input type='submit' name='submit' id='submit' value='Supprimer'>
                    </form>
                </div>
                <div class="centre">
                    <?php
                    if($_SESSION['role'] == "Secrétaire") {
                        ?>
                        <a href="./accueil_secretaire.php"><input type='submit' value='RETOUR'></a>
                        <?php
                    } else {
                        ?>
                        <a href="../../pages_admin/admin_accueil.php"><input type='submit' value='RETOUR'></a>
                        <?php
                    }
                    ?>
                </div>
                <div id="hide1">
                    <p id="erreur"></p>
                </div>
                <?php
                if(isset($_POST['submit'])) {
                    try {
                        // Ne pas décommenter
                        //$key = file_get_contents('/var/www/secrets/key.key');
                        //$cipher = "aes-256-cbc";
                        //$iv = file_get_contents('/var/www/secrets/iv.iv');
                        $preadmi = $_POST['preadmi'];
                        $count = $connexion->prepare("SELECT count(*) FROM Preadmi INNER JOIN Patient ON Patient.id_patient = Preadmi.id_patient WHERE patient.id_patient = :id_patient");
                        $id_patient_sql = "SELECT Patient.id_patient FROM Patient INNER JOIN Preadmi ON Patient.id_patient = Preadmi.id_patient WHERE Preadmi.id = :id";
                        $conn1 = $connexion->prepare($id_patient_sql);
                        $conn1->bindParam(':id', $preadmi);
                        $conn1->execute();
                        $id_patient = $conn1->fetchAll();
                        $id_patient_res = $id_patient[0]['id_patient'];
                        $count->bindParam(':id_patient', $id_patient_res);
                        $count->execute();
                        $id_perspre_sql = "SELECT Personnepre.id FROM Personnepre INNER JOIN Patient ON Patient.id_perspre = Personnepre.id WHERE Patient.id_patient = :id";
                        $conn2 = $connexion->prepare($id_perspre_sql);
                        $conn2->bindParam(':id', $id_patient_res);
                        $conn2->execute();
                        $id_perspre = $conn2->fetchAll();
                        $id_perspre_res = $id_perspre[0]['id'];
                        $id_persconf_sql = "SELECT Personneconf.id FROM Personneconf INNER JOIN Patient ON Patient.id_persconf = Personneconf.id WHERE Patient.id_patient = :id";
                        $conn4 = $connexion->prepare($id_persconf_sql);
                        $conn4->bindParam(':id', $id_patient_res);
                        $conn4->execute();
                        $id_persconf = $conn4->fetchAll();
                        $id_persconf_res = $id_persconf[0]['id'];
                        $sup_sql = "DELETE FROM Preadmi WHERE id = :id";
                        $conn = $connexion->prepare($sup_sql);
                        $conn->bindParam(':id', $preadmi);
                        $conn->execute();
                        $count_res = $count->fetchAll(PDO::FETCH_ASSOC);
                        $count1 = $count_res[0]['count(*)'];
                        if($count1 == 1) {
                            $sup_sql2 = "DELETE FROM Sociale WHERE id_patient = :id_patient";
                            $conn3 = $connexion->prepare($sup_sql2);
                            $conn3->bindParam(':id_patient', $id_patient_res);
                            $conn3->execute();
                            $sup_sql3 = "DELETE FROM Personnepre WHERE id = :id";
                            $conn5 = $connexion->prepare($sup_sql3);
                            $conn5->bindParam(':id', $id_perspre_res);
                            $conn5->execute();
                            $sup_sql4 = "DELETE FROM Personneconf WHERE id = :id";
                            $conn6 = $connexion->prepare($sup_sql4);
                            $conn6->bindParam(':id', $id_persconf_res);
                            $conn6->execute();
                        }
                        echo "<h1>Suppression réussie!</h1>";
                    } catch (PDOException $e) {
                        echo("erreur lors de la suppression!" . $e->getMessage() . "<br>");
                    }
                }
            } else {
                ?>
                <div class="bloc">
                    <div class="item2">
                        <img src="../../images/cadenas.jpg" height="50%" width="20%"><br>
                        <h1>Accès Interdit!</h1><br>
                        <p>Vous n'êtes pas autorisé à être ici!</p>
                        <p>Si vous essayez d'accéder à une page sans autorisation, vous vous exposez à une suspension de votre compte, à des poursuites et à des sanctions légales.</p>
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
