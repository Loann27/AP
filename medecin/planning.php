<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <title>Les rendez-vous</title>
        <meta charset="utf-8">
        <link href="../../css/index.css" rel="stylesheet">
    </head>
    <body>
        <div id="recherche_mois">
            <h1>Filtrage par rapport au mois</h1><br/>
            <form action="planning.php" method="POST">
                <select name="month" id="month" required>
                    <option value="">---</option>
                    <option value="all">Tous</option>
                    <option value="before">Mois passés</option>
                    <option value="now">Mois en cours</option>
                    <option value="after">Prochains mois</option>
                </select><br/><br/>
                <input type="submit" name="submit" id="submit" value="Recherche">
            </form>
        </div>
        <?php
        if(isset($_SESSION['compte'])) {
            if(($_SESSION['role'] == 'Admin')) {
                ?>
                <h1>Les rendez-vous des patients</h1>
                <?php
                if(isset($_POST['submit'])) {
                    if($_POST['month'] == "all") {
                        try {
                            $serveur = "localhost";
                            $utilisateur = "root";
                            $motDePasse = "sio2024";
                            $nomBDD = "hopital";
                            $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
                            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                            $table1 = "Preadmi";
                            $table2 = "Patient";
                            $table3 = "Professionnel";
        
                            $donnee1 = "nom";
                            $donnee2 = "prenom";
                            $donnee3 = "nom_naissance";
                            $donneeEp = "nom_epouse";
                            $donnee4 = "date_preadmi";
                            $donnee5 = "heure";
        
                            $lien1 = "id_medecin";
                            $lien2 = "id";
                            $lien3 = "id_patient";
        
                            $sql = $connexion->prepare("SELECT $table1.$donnee4, $table1.$donnee5, $table2.$donnee2, $table2.$donneeEp, $table2.$donnee3, $table3.$donnee1 AS 'Nom du médecin', $table3.$donnee2 AS 'Prénom du médecin' FROM $table1 INNER JOIN $table3 ON $table1.$lien1 = $table3.$lien2 INNER JOIN $table2 ON $table1.$lien3 = $table2.$lien3;");
                            $sql->execute();
                            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo "Erreur lors de la connexion à la base de donnée : " . $e->getMessage();
                        }
                    } else if($_POST['month'] == "before") {
                        try {
                            $serveur = "localhost";
                            $utilisateur = "root";
                            $motDePasse = "sio2024";
                            $nomBDD = "hopital";
                            $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
                            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                            $table1 = "Preadmi";
                            $table2 = "Patient";
                            $table3 = "Professionnel";
        
                            $donnee1 = "nom";
                            $donnee2 = "prenom";
                            $donnee3 = "nom_naissance";
                            $donneeEp = "nom_epouse";
                            $donnee4 = "date_preadmi";
                            $donnee5 = "heure";
        
                            $lien1 = "id_medecin";
                            $lien2 = "id";
                            $lien3 = "id_patient";
        
                            $sql = $connexion->prepare("SELECT $table1.$donnee4, $table1.$donnee5, $table2.$donnee2, $table2.$donneeEp, $table2.$donnee3, $table3.$donnee1 AS 'Nom du médecin', $table3.$donnee2 AS 'Prénom du médecin' FROM $table1 INNER JOIN $table3 ON $table1.$lien1 = $table3.$lien2 INNER JOIN $table2 ON $table1.$lien3 = $table2.$lien3 WHERE ((MONTH(date_preadmi) <= MONTH(CURRENT_DATE) - 1 AND YEAR(date_preadmi) = YEAR(CURRENT_DATE)) OR (MONTH(date_preadmi) <= 12 AND MONTH(CURRENT_DATE) = 1 AND YEAR(date_preadmi) <= YEAR(CURRENT_DATE) - 1));");
                            $sql->execute();
                            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo "Erreur lors de la connexion à la base de donnée : " . $e->getMessage();
                        }
                    } else if($_POST['month'] == "now") {
                        try {
                            $serveur = "localhost";
                            $utilisateur = "root";
                            $motDePasse = "sio2024";
                            $nomBDD = "hopital";
                            $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
                            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                            $table1 = "Preadmi";
                            $table2 = "Patient";
                            $table3 = "Professionnel";
        
                            $donnee1 = "nom";
                            $donnee2 = "prenom";
                            $donnee3 = "nom_naissance";
                            $donneeEp = "nom_epouse";
                            $donnee4 = "date_preadmi";
                            $donnee5 = "heure";
        
                            $lien1 = "id_medecin";
                            $lien2 = "id";
                            $lien3 = "id_patient";
        
                            $sql = $connexion->prepare("SELECT $table1.$donnee4, $table1.$donnee5, $table2.$donnee2, $table2.$donneeEp, $table2.$donnee3, $table3.$donnee1 AS 'Nom du médecin', $table3.$donnee2 AS 'Prénom du médecin' FROM $table1 INNER JOIN $table3 ON $table1.$lien1 = $table3.$lien2 INNER JOIN $table2 ON $table1.$lien3 = $table2.$lien3 WHERE MONTH(date_preadmi) = MONTH(CURRENT_DATE) AND YEAR(date_preadmi) = YEAR(CURRENT_DATE);");
                            $sql->execute();
                            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo "Erreur lors de la connexion à la base de donnée : " . $e->getMessage();
                        }
                    } else {
                        try {
                            $serveur = "localhost";
                            $utilisateur = "root";
                            $motDePasse = "sio2024";
                            $nomBDD = "hopital";
                            $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
                            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                            $table1 = "Preadmi";
                            $table2 = "Patient";
                            $table3 = "Professionnel";
        
                            $donnee1 = "nom";
                            $donnee2 = "prenom";
                            $donnee3 = "nom_naissance";
                            $donneeEp = "nom_epouse";
                            $donnee4 = "date_preadmi";
                            $donnee5 = "heure";
        
                            $lien1 = "id_medecin";
                            $lien2 = "id";
                            $lien3 = "id_patient";
        
                            $sql = $connexion->prepare("SELECT $table1.$donnee4, $table1.$donnee5, $table2.$donnee2, $table2.$donneeEp, $table2.$donnee3, $table3.$donnee1 AS 'Nom du médecin', $table3.$donnee2 AS 'Prénom du médecin' FROM $table1 INNER JOIN $table3 ON $table1.$lien1 = $table3.$lien2 INNER JOIN $table2 ON $table1.$lien3 = $table2.$lien3 WHERE ((MONTH(date_preadmi) >= MONTH(CURRENT_DATE) + 1 AND YEAR(date_preadmi) = YEAR(CURRENT_DATE)) OR (MONTH(date_preadmi) >= 1 AND MONTH(CURRENT_DATE) = 12 AND YEAR(date_preadmi) >= YEAR(CURRENT_DATE) + 1));");
                            $sql->execute();
                            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo "Erreur lors de la connexion à la base de donnée : " . $e->getMessage();
                        }
                    }
                } else {
                    try {
                        $serveur = "localhost";
                        $utilisateur = "root";
                        $motDePasse = "sio2024";
                        $nomBDD = "hopital";
                        $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
                        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                        $table1 = "Preadmi";
                        $table2 = "Patient";
                        $table3 = "Professionnel";
    
                        $donnee1 = "nom";
                        $donnee2 = "prenom";
                        $donnee3 = "nom_naissance";
                        $donneeEp = "nom_epouse";
                        $donnee4 = "date_preadmi";
                        $donnee5 = "heure";
    
                        $lien1 = "id_medecin";
                        $lien2 = "id";
                        $lien3 = "id_patient";
    
                        $sql = $connexion->prepare("SELECT $table1.$donnee4, $table1.$donnee5, $table2.$donnee2, $table2.$donneeEp, $table2.$donnee3, $table3.$donnee1 AS 'Nom du médecin', $table3.$donnee2 AS 'Prénom du médecin' FROM $table1 INNER JOIN $table3 ON $table1.$lien1 = $table3.$lien2 INNER JOIN $table2 ON $table1.$lien3 = $table2.$lien3;");
                        $sql->execute();
                        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo "Erreur lors de la connexion à la base de donnée : " . $e->getMessage();
                    }
    
                    ?>
                    <table>
                        <thead>
                            <tr>
                                <?php
                                // Affichage des en-têtes de colonne
                                if (!empty($result)) {
                                    foreach ($result[0] as $cle => $valeur) {
                                        echo "<th>" . htmlspecialchars($cle) . "</th>";
                                    }
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Affichage des lignes de données
                            foreach ($result as $ligne) {
                                echo "<tr>";
                                foreach ($ligne as $valeur) {
                                    echo "<td>" . htmlspecialchars($valeur) . "</td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                }
            } else if(($_SESSION['role'] == 'Médecin') || ($_SESSION['role'] == "Chirurgien")) {
                ?>
                <h1>Les rendez-vous de vos patients</h1>
                <?php
                if(isset($_POST['submit'])) {
                    if($_POST['month'] == "all") {
                        try {
                            $serveur = "localhost";
                            $utilisateur = "root";
                            $motDePasse = "sio2024";
                            $nomBDD = "hopital";
                            $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
                            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                            $table1 = "Preadmi";
                            $table2 = "Patient";
                            $table3 = "Professionnel";
        
                            $donnee1 = "nom";
                            $donnee2 = "prenom";
                            $donnee3 = "nom_naissance";
                            $donneeEp = "nom_epouse";
                            $donnee4 = "date_preadmi";
                            $donnee5 = "heure";
        
                            $lien1 = "id_medecin";
                            $lien2 = "id";
                            $lien3 = "id_patient";
        
                            $condition = substr($_SESSION['compte'], 2);
        
                            $sql = $connexion->prepare("SELECT $table1.$donnee4, $table1.$donnee5, $table2.$donnee2, $table2.$donneeEp, $table2.$donnee3 FROM $table1 INNER JOIN $table3 ON $table1.$lien1 = $table3.$lien2 INNER JOIN $table2 ON $table1.$lien3 = $table2.$lien3 WHERE $table3.$donnee1 = :condition;");
                            $sql->bindParam(':condition', $condition);
                            $sql->execute();
                            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo "Erreur lors de la connexion à la base de donnée : " . $e->getMessage();
                        }
                    } else if($_POST['month'] == "before") {
                        try {
                            $serveur = "localhost";
                            $utilisateur = "root";
                            $motDePasse = "sio2024";
                            $nomBDD = "hopital";
                            $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
                            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                            $table1 = "Preadmi";
                            $table2 = "Patient";
                            $table3 = "Professionnel";
        
                            $donnee1 = "nom";
                            $donnee2 = "prenom";
                            $donnee3 = "nom_naissance";
                            $donneeEp = "nom_epouse";
                            $donnee4 = "date_preadmi";
                            $donnee5 = "heure";
        
                            $lien1 = "id_medecin";
                            $lien2 = "id";
                            $lien3 = "id_patient";
        
                            $condition = substr($_SESSION['compte'], 2);
        
                            $sql = $connexion->prepare("SELECT $table1.$donnee4, $table1.$donnee5, $table2.$donnee2, $table2.$donneeEp, $table2.$donnee3 FROM $table1 INNER JOIN $table3 ON $table1.$lien1 = $table3.$lien2 INNER JOIN $table2 ON $table1.$lien3 = $table2.$lien3 WHERE $table3.$donnee1 = :condition AND ((MONTH(date_preadmi) <= MONTH(CURRENT_DATE) - 1 AND YEAR(date_preadmi) = YEAR(CURRENT_DATE)) OR (MONTH(date_preadmi) <= 12 AND MONTH(CURRENT_DATE) = 1 AND YEAR(date_preadmi) <= YEAR(CURRENT_DATE) - 1));");
                            $sql->bindParam(':condition', $condition);
                            $sql->execute();
                            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo "Erreur lors de la connexion à la base de donnée : " . $e->getMessage();
                        }
                    } else if($_POST['month'] == "now") {
                        try {
                            $serveur = "localhost";
                            $utilisateur = "root";
                            $motDePasse = "sio2024";
                            $nomBDD = "hopital";
                            $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
                            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                            $table1 = "Preadmi";
                            $table2 = "Patient";
                            $table3 = "Professionnel";
        
                            $donnee1 = "nom";
                            $donnee2 = "prenom";
                            $donnee3 = "nom_naissance";
                            $donneeEp = "nom_epouse";
                            $donnee4 = "date_preadmi";
                            $donnee5 = "heure";
        
                            $lien1 = "id_medecin";
                            $lien2 = "id";
                            $lien3 = "id_patient";
        
                            $condition = substr($_SESSION['compte'], 2);
        
                            $sql = $connexion->prepare("SELECT $table1.$donnee4, $table1.$donnee5, $table2.$donnee2, $table2.$donneeEp, $table2.$donnee3 FROM $table1 INNER JOIN $table3 ON $table1.$lien1 = $table3.$lien2 INNER JOIN $table2 ON $table1.$lien3 = $table2.$lien3 WHERE $table3.$donnee1 = :condition AND (MONTH(date_preadmi) = MONTH(CURRENT_DATE) AND YEAR(date_preadmi) = YEAR(CURRENT_DATE));");
                            $sql->bindParam(':condition', $condition);
                            $sql->execute();
                            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo "Erreur lors de la connexion à la base de donnée : " . $e->getMessage();
                        }
                    } else {
                        try {
                            $serveur = "localhost";
                            $utilisateur = "root";
                            $motDePasse = "sio2024";
                            $nomBDD = "hopital";
                            $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
                            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                            $table1 = "Preadmi";
                            $table2 = "Patient";
                            $table3 = "Professionnel";
        
                            $donnee1 = "nom";
                            $donnee2 = "prenom";
                            $donnee3 = "nom_naissance";
                            $donneeEp = "nom_epouse";
                            $donnee4 = "date_preadmi";
                            $donnee5 = "heure";
        
                            $lien1 = "id_medecin";
                            $lien2 = "id";
                            $lien3 = "id_patient";
        
                            $condition = substr($_SESSION['compte'], 2);
        
                            $sql = $connexion->prepare("SELECT $table1.$donnee4, $table1.$donnee5, $table2.$donnee2, $table2.$donneeEp, $table2.$donnee3 FROM $table1 INNER JOIN $table3 ON $table1.$lien1 = $table3.$lien2 INNER JOIN $table2 ON $table1.$lien3 = $table2.$lien3 WHERE $table3.$donnee1 = :condition AND ((MONTH(date_preadmi) >= MONTH(CURRENT_DATE) + 1 AND YEAR(date_preadmi) = YEAR(CURRENT_DATE)) OR (MONTH(date_preadmi) >= 1 AND MONTH(CURRENT_DATE) = 12 AND YEAR(date_preadmi) >= YEAR(CURRENT_DATE) + 1));");
                            $sql->bindParam(':condition', $condition);
                            $sql->execute();
                            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo "Erreur lors de la connexion à la base de donnée : " . $e->getMessage();
                        }
                    }
                } else {
                    try {
                        $serveur = "localhost";
                        $utilisateur = "root";
                        $motDePasse = "sio2024";
                        $nomBDD = "hopital";
                        $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
                        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                        $table1 = "Preadmi";
                        $table2 = "Patient";
                        $table3 = "Professionnel";
    
                        $donnee1 = "nom";
                        $donnee2 = "prenom";
                        $donnee3 = "nom_naissance";
                        $donneeEp = "nom_epouse";
                        $donnee4 = "date_preadmi";
                        $donnee5 = "heure";
    
                        $lien1 = "id_medecin";
                        $lien2 = "id";
                        $lien3 = "id_patient";
    
                        $condition = substr($_SESSION['compte'], 2);
    
                        $sql = $connexion->prepare("SELECT $table1.$donnee4, $table1.$donnee5, $table2.$donnee2, $table2.$donneeEp, $table2.$donnee3 FROM $table1 INNER JOIN $table3 ON $table1.$lien1 = $table3.$lien2 INNER JOIN $table2 ON $table1.$lien3 = $table2.$lien3 WHERE $table3.$donnee1 = :condition;");
                        $sql->bindParam(':condition', $condition);
                        $sql->execute();
                        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo "Erreur lors de la connexion à la base de donnée : " . $e->getMessage();
                    }
                }
                ?>
                <table>
                    <thead>
                        <tr>
                            <?php
                            // Affichage des en-têtes de colonne
                            if (!empty($result)) {
                                foreach ($result[0] as $cle => $valeur) {
                                    echo "<th>" . htmlspecialchars($cle) . "</th>";
                                }
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Affichage des lignes de données
                        foreach ($result as $ligne) {
                            echo "<tr>";
                            foreach ($ligne as $valeur) {
                                echo "<td>" . htmlspecialchars($valeur) . "</td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
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
