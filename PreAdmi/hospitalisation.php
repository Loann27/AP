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
            if(($_SESSION['role'] == 'Secrétaire') || ($_SESSION['role'] == "Admin")) {
                ?>
                <div id='bloc1'>
                    <h1>Formulaire Pré-Admission</h1>
                    <form id="myForm" method="POST" action="hospitalisation.php" enctype="multipart/form-data">
                        <label for='preadmi'>Pré-admission pour:*</label>
                        <select name='preadmi' id='preadmi' required>
                            <option value=''>Choix</option>
                            <option value='Ambulatoire chirurgie'>Ambulatoire chirurgie</option>
                            <option value='Hospitalisation'>Hospitalisation (au moins une nuit)</option>
                        </select><br><br>
                        <label for='date_hospi'>Date hospitalisation:* </label>
                        <input class="input" id='date_hospi' name='date_hospi' type='date' onchange='verif()' required><br/>
                        <label for='heure'>Heure de l'intervention (7:00 - 16:30):* </label>
                        <input class="input" id='heure' name='heure' type='time' placeholder='--:--' onchange='verif_time(this.value)' required><br><br>
                        <label for='medecin'>Nom du médecin*</label><br>
                        <select name='medecin' id='medecin' required>
                            <option value=''>Choix</option>
                            <option value='COVILLON'>Alexandrie COVILLON (Maxillo-facial)</option>
                            <option value='MARQUIS'>Françoise MARQUIS (Radiologue)</option>
                            <option value='FAURE'>Hugues FAURE (Neurologue)</option>
                        </select><br><br>
                        <h1>Informations concernant le patient</h1>
                        <label for='civ'>Civ. </label>
                        <select name='civ' id='civ' required>
                            <option value=''>Choix</option>
                            <option value='Homme'>Homme</option>
                            <option value='Femme'>Femme</option>
                        </select><br/>
                        <label for='nom_naissance'>Nom de naissance </label>
                        <input id='nom_naissance' name='nom_naissance' type='text' required><br/>
                        <label for='nom_epouse'>Nom d'épouse </label>
                        <input id='nom_epouse' name='nom_epouse' type='text'><br><br>
                        <label for='prenom'>Prénom </label>
                        <input type='text' id='prenom' name='prenom' required><br/>
                        <label for='date_naissance'>Date de naissance </label>
                        <input type='date' id='date_naissance' name='date_naissance' required><br><br>
                        <label for='adresse'>Adresse </label>
                        <input type='text' id='adresse' name='adresse' required><br><br>
                        <label for='cp'>Code Postal </label>
                        <input type='tel' id='cp' name='cp' pattern='[0-9]{5}' required><br/>
                        <label for='ville'>Ville </label>
                        <input type='text' id='ville' name='ville' required><br><br>
                        <label for='email'>Email (.com, .fr, .en, .net, .co.uk)</label>
                        <input class="input" type='mail' id='email' name='email' onchange="verif_patients()" required><br/><br/>
                        <label for='telephone'>Téléphone </label>
                        <input type='tel' id='telephone' name='telephone' pattern='[0-9]{10}' required><br><br>
                        <h1>Coordonnées personne à prévenir</h1>
                        <label for='nom_prev'>Nom </label>
                        <input type='text' name='nom_prev' id='nom_prev' required><br/>
                        <label for='pren_prev'>Prénom </label>
                        <input type='text' name='pren_prev' id='pren_prev' required><br/>
                        <label for='tel_prev'>Téléphone </label>
                        <input class="input" type='tel' name='tel_prev' id='tel_prev' pattern='[0-9]{10}' onchange="verif_prevenir()" required><br/>
                        <label for='adr_prev'>Adresse</label>
                        <input type='text' name='adr_prev' id='adr_prev' required><br/>
                        <h1>Coordonnées personne de confiance</h1>
                        <label for='nom_conf'>Nom </label>
                        <input type='text' name='nom_conf' id='nom_conf' required><br/>
                        <label for='pren_conf'>Prénom </label>
                        <input type='text' name='pren_conf' id='pren_conf' required><br/>
                        <label for='tel_conf'>Téléphone </label>
                        <input class="input" type='tel' name='tel_conf' id='tel_conf' pattern='[0-9]{10}' onchange="verif_confiance()" required><br/>
                        <label for='adr_conf'>Adresse</label>
                        <input type='text' name='adr_conf' id='adr_conf' required><br/><br/>
                        <h1>Couverture Sociale</h1>
                        <label for='orga'>Organisme de sécurité sociale / Nom de la caisse d'assurance maladie* </label>
                        <input type='text' name='orga' id='orga' placeholder='Ex: CPAM du Tarn et Garonne, CPAM du Lot, RSI, MSA...' required><br/>
                        <label for='num_secu'>Numéro de sécurité sociale* </label>
                        <input class="input" type='tel' name='num_secu' id='num_secu' pattern='[0-9]{15}' onchange="verif_num_secu()" required><br/>
                        <label for='assure'>Le patient est-il assuré?* </label>
                        <select name='assure' id='assure' required>
                            <option value=''>Choix</option>
                            <option value='oui'>Oui</option>
                            <option value='non'>Non</option>
                        </select><br/>
                        <label for='ald'>Le patient est-il ALD?* </label>
                        <select name='ald' id='ald' required>
                            <option value=''>Choix</option>
                            <option value='oui'>Oui</option>
                            <option value='non'>Non</option>
                        </select><br/>
                        <label for='nom_mutu'>Nom de la mutuelle ou de l'assurance* </label>
                        <input type='text' name='nom_mutu' id='nom_mutu' required><br/>
                        <label for='num_adherent'>Numéro adhérent* </label>
                        <input type='tel' name='num_adherent' id='num_adherent' required><br/>
                        <label for='chambre_part'>Chambre particulière?* </label>
                        <select name='chambre_part' id='chambre_part' required>
                            <option value=''>Choix</option>
                            <option value='oui'>Oui</option>
                            <option value='non'>Non</option>
                        </select><br/><br/>
                        <h1>Documents</h1>
                        <label for='identity'>Carte d'identité (recto / verso):</label>
                        <input type='file' id='identity' name="identity" accept='.jpg, .png, .pdf' required><br/>
                        <label for='carteVitale'>Carte vitale:</label>
                        <input type='file' id='carteVitale' name="carteVitale" accept='.jpg, .png, .pdf' required><br/>
                        <label for='mutuelle'>Carte de mutuelle:</label>
                        <input type='file' id='mutuelle' name='mutuelle' accept='.jpg, .png, .pdf' required><br/>
                        <label for='livretFamille'>Livret de famille (pour enfants mineurs):</label>
                        <input type='file' id='livretFamille' name='livretFamille' accept='.jpg, .png, .pdf'><br/>
                        <input type='submit' name='submit' id='submit' value='Valider'>
                    </form>
                </div>
                <div class="centre">
                    <a href="./accueil_secretaire.php"><input type='submit' value='RETOUR'></a>
                </div>
                <div id="hide1">
                    <p id="erreur"></p>
                </div>
                <?php
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $serveur = "localhost";
                $utilisateur = "root";
                $motDePasse = "sio2024";
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
                if(isset($_POST['submit'])) {
                    try {
                        // Ne pas décommenter
                        //$key = file_get_contents('/var/www/secrets/key.key');
                        //$cipher = "aes-256-cbc";
                        //$iv = file_get_contents('/var/www/secrets/iv.iv');
                        $preadmi = $_POST['preadmi'];
                        $date_hospi = $_POST['date_hospi'];
                        $heure = $_POST['heure'];
                        $medecin = $_POST['medecin'];
                        $civ = $_POST['civ'];
                        $nom_nais = $_POST['nom_naissance'];
                        $nom_ep = isset($_POST['nom_epouse']) ? $_POST["nom_epouse"] : null;
                        $pren = $_POST["prenom"];
                        $date_nais = $_POST['date_naissance'];
                        $adr = $_POST['adresse'];
                        $cp = $_POST['cp'];
                        $ville = $_POST['ville'];
                        $email = $_POST['email'];
                        $tel = $_POST['telephone'];
                        $nom_prev = $_POST['nom_prev'];
                        $pren_prev = $_POST['pren_prev'];
                        $tel_prev = $_POST['tel_prev'];
                        $adr_prev = $_POST['adr_prev'];
                        $nom_conf = $_POST['nom_conf'];
                        $pren_conf = $_POST['pren_conf'];
                        $tel_conf = $_POST['tel_conf'];
                        $adr_conf = $_POST['adr_conf'];
                        $orga = $_POST['orga'];
                        $num_secu = $_POST['num_secu'];
                        $assure = $_POST['assure'];
                        $ald = $_POST['ald'];
                        $nom_mutu = $_POST['nom_mutu'];
                        $num_adherent = $_POST['num_adherent'];
                        $chambre_part = $_POST['chambre_part'];
                        $mimeIdentite = mime_content_type($_FILES['identity']['tmp_name']);
                        $fileIdentite = file_get_contents($_FILES['identity']['tmp_name']);
                        $baseIdentite = base64_encode($fileIdentite);
                        $doc_identite = 'data:' . $mimeIdentite . ';base64,' . $baseIdentite;
                        //$doc_identite = openssl_encrypt($doc_identite, $cipher, $key, 0, $iv);
                        $mimeVitale = mime_content_type($_FILES['carteVitale']['tmp_name']);
                        $fileVitale = file_get_contents($_FILES['carteVitale']['tmp_name']);
                        $baseVitale = base64_encode($fileVitale);
                        $doc_vitale = 'data:' . $mimeVitale . ';base64,' . $baseVitale;
                        //$doc_vitale = openssl_encrypt($doc_vitale, $cipher, $key, 0, $iv);
                        $mimeMutuelle = mime_content_type($_FILES['mutuelle']['tmp_name']);
                        $fileMutuelle = file_get_contents($_FILES['mutuelle']['tmp_name']);
                        $baseMutuelle = base64_encode($fileMutuelle);
                        $doc_mutuelle = 'data:' . $mimeMutuelle . ';base64,' . $baseMutuelle;
                        //$doc_mutuelle = openssl_encrypt($doc_mutuelle, $cipher, $key, 0, $iv);
                        if(isset($_FILES['livretFamille']) && $_FILES['livretFamille']['size'] > 0) {
                            $mimeLivret = mime_content_type($_FILES['livretFamille']['tmp_name']);
                            $fileLivret = file_get_contents($_FILES['livretFamille']['tmp_name']);
                            $baseLivret = base64_encode($fileLivret);
                            $doc_livret = 'data:' . $mimeLivret . ';base64,' . $baseLivret;
                            //$doc_livret = openssl_encrypt($doc_livret, $cipher, $key, 0, $iv);
                        }
                        $count = "SELECT count(*) FROM Hospitalisation;";
                        $count2 = "SELECT count(*) FROM Patient;";
                        $count3 = "SELECT count(*) FROM Sociale;";
                        $count4 = "SELECT count(*) FROM Personnepre;";
                        $count5 = "SELECT count(*) FROM Personneconf;";
                        $count6 = "SELECT count(*) FROM PieceJointe;";
                        $count7 = "SELECT count(*) FROM Preadmi;";
                        $id = $connexion->prepare($count);
                        $id->execute();
                        $id_res = $id->fetchAll(PDO::FETCH_ASSOC);
                        $id1 = $id_res[0]['count(*)'] + 1;
                        $id_patient = $connexion->prepare($count2);
                        $id_patient->execute();
                        $id_patient_res = $id_patient->fetchAll(PDO::FETCH_ASSOC);
                        $id_patient1 = $id_patient_res[0]['count(*)'] + 1;
                        $id_sociale = $connexion->prepare($count3);
                        $id_sociale->execute();
                        $id_sociale_res = $id_sociale->fetchAll(PDO::FETCH_ASSOC);
                        $id_sociale1 = $id_sociale_res[0]['count(*)'] + 1;
                        $id_prev = $connexion->prepare($count4);
                        $id_prev->execute();
                        $id_prev_res = $id_prev->fetchAll(PDO::FETCH_ASSOC);
                        $id_prev1 = $id_prev_res[0]['count(*)'] + 1;
                        $id_conf = $connexion->prepare($count5);
                        $id_conf->execute();
                        $id_conf_res = $id_conf->fetchAll(PDO::FETCH_ASSOC);
                        $id_conf1 = $id_conf_res[0]['count(*)'] + 1;
                        $id_piece = $connexion->prepare($count6);
                        $id_piece->execute();
                        $id_piece_res = $id_piece->fetchAll(PDO::FETCH_ASSOC);
                        $id_piece1 = $id_piece_res[0]['count(*)'] + 1;
                        $id_preadmi = $connexion->prepare($count7);
                        $id_preadmi->execute();
                        $id_preadmi_res = $id_preadmi->fetchAll(PDO::FETCH_ASSOC);
                        $id_preadmi1 = $id_preadmi_res[0]['count(*)'] + 1;
                        $id_medecin = "SELECT id FROM Professionnel WHERE nom = :medecin;";
                        $id_med = $connexion->prepare($id_medecin);
                        $id_med->bindParam(':medecin', $medecin);
                        $id_med->execute();
                        $id_med_res = $id_med->fetchAll(PDO::FETCH_ASSOC);
                        $id_med1 = $id_med_res[0]['id'];
                        $sql1 = "INSERT INTO Hospitalisation (id_hospitalisation, date_hospi, nom_medecin, chambre) VALUES (:id1, :date_hospi, :medecin, :chambre_part);";
                        $verif = $connexion->prepare("SELECT count(*) FROM Patient WHERE nom_naissance = :nom_nais, nom_epouse = :nom_ep, prenom = :pren, date_naissance, :date_nais, adresse = :adr, CP = :cp, ville = :ville, email = :email, telephone = :tel, genre = :civ;");
                        $verif->bindParam(':nom_nais', $nom_nais);
                        $verif->bindParam(':nom_ep', $nom_ep);
                        $verif->bindParam(':pren', $pren);
                        $verif->bindParam(':date_nais', $date_nais);
                        $verif->bindParam(':adr', $adr);
                        $verif->bindParam(':cp', $cp);
                        $verif->bindParam(':ville', $ville);
                        $verif->bindParam(':email', $email);
                        $verif->bindParam(':tel', $tel);
                        $verif->bindParam(':civ', $civ);
                        $verif->execute();
                        if($verif->fetchColumn() == 0) {
                            if($nom_ep) {
                                $sql2 = "INSERT INTO Patient (id_patient, nom_naissance, nom_epouse, prenom, date_naissance, adresse, CP, ville, email, telephone, genre) VALUES (:id_patient1, :nom_nais, :nom_ep, :pren, :date_nais, :adr, :cp, :ville, :email, :tel, :civ);";
                                $conn2 = $connexion->prepare($sql2);
                                $conn2->bindParam(':nom_ep', $nom_ep);
                            } else {
                                $sql2 = "INSERT INTO Patient (id_patient, nom_naissance, prenom, date_naissance, adresse, CP, ville, email, telephone, genre) VALUES (:id_patient1, :nom_nais, :pren, :date_nais, :adr, :cp, :ville, :email, :tel, :civ);";
                                $conn2 = $connexion->prepare($sql2);
                            }
                        } else {
                            
                        }
                        $verif2 = $connexion->prepare("SELECT count(*) FROM Personnepre WHERE nom = :nom_pre, prenom = :pren_pre, tel = :tel_pre, adresse = :adr_pre;");
                        $verif2->bindParam(':nom_pre', $nom_prev);
                        $verif2->bindParam(':pren_pre', $pren_prev);
                        $verif2->bindParam(':tel_pre', $tel_prev);
                        $verif2->bindParam('adr_pre', $adr_prev);
                        $verif2->execute();
                        if($verif2->fetchColumn() == 0) {
                            $sql3 = "INSERT INTO Personnepre VALUES (:id_prev1, :nom_prev, :pren_prev, :tel_prev, :adr_prev);";
                        }
                        $sql4 = "INSERT INTO Personneconf VALUES (:id_conf1, :nom_conf, :pren_conf, :tel_conf, :adr_conf);";
                        if(isset($_POST['livretFamille'])) {
                            $sql5 = "INSERT INTO PieceJointe (id, recto_verso_identite, carte_vitale, carte_mutuelle, livret_famille) VALUES (:id_piece1, :doc_identite, :doc_vitale, :doc_mutuelle, :doc_livret);";
                            $conn5 = $connexion->prepare($sql5);
                            $conn5->bindParam(':doc_livret', $doc_livret);
                        } else {
                            $sql5 = "INSERT INTO PieceJointe (id, recto_verso_identite, carte_vitale, carte_mutuelle) VALUES (:id_piece1, :doc_identite, :doc_vitale, :doc_mutuelle);";
                            $conn5 = $connexion->prepare($sql5);
                        }
                        $sql6 = "INSERT INTO Preadmi (id, date_preadmi, heure) VALUES (:id_preadmi1, :date_hospi, :heure);";
                        $sql7 = "INSERT INTO Sociale (id, organisme_secu_sociale, num_secu, assure, ALD, nom_mutuelle, num_adherent, chambre_particuliere) VALUES (:id_sociale1, :orga, :num_secu, :assure, :ald, :nom_mutu, :num_adherent, :chambre_part);";
                        $conn1 = $connexion->prepare($sql1);
                        $conn1->bindParam(':id1', $id1);
                        $conn1->bindParam(':date_hospi', $date_hospi);
                        $conn1->bindParam(':medecin', $medecin);
                        $conn1->bindParam(':chambre_part', $chambre_part);
                        try {
                            $conn1->execute();
                        } catch (PDOException $e) {
                            echo "Erreur Hospitalisation: " . $e->getMessage() . "<br>";
                        }
                        $conn2->bindParam(':id_patient1', $id_patient1);
                        $conn2->bindParam(':nom_nais', $nom_nais);
                        $conn2->bindParam(':pren', $pren);
                        $conn2->bindParam(':date_nais', $date_nais);
                        $conn2->bindParam(':adr', $adr);
                        $conn2->bindParam(':cp', $cp);
                        $conn2->bindParam(':ville', $ville);
                        $conn2->bindParam(':email', $email);
                        $conn2->bindParam(':tel', $tel);
                        $conn2->bindParam(':civ', $civ);
                        try {
                            $conn2->execute();
                        } catch (PDOException $e) {
                            echo "Erreur Patient: " . $e->getMessage() . "<br>";
                        }
                        $conn3 = $connexion->prepare($sql3);
                        $conn3->bindParam(':id_prev1', $id_prev1);
                        $conn3->bindParam(':nom_prev', $nom_prev);
                        $conn3->bindParam(':pren_prev', $pren_prev);
                        $conn3->bindParam(':tel_prev', $tel_prev);
                        $conn3->bindParam(':adr_prev', $adr_prev);
                        try {
                            $conn3->execute();
                        } catch (PDOException $e) {
                            echo "Erreur Personnepre: " . $e->getMessage() . "<br>";
                        }
                        $conn4 = $connexion->prepare($sql4);
                        $conn4->bindParam(':id_conf1', $id_conf1);
                        $conn4->bindParam(':nom_conf', $nom_conf);
                        $conn4->bindParam(':pren_conf', $pren_conf);
                        $conn4->bindParam(':tel_conf', $tel_conf);
                        $conn4->bindParam(':adr_conf', $adr_conf);
                        try {
                            $conn4->execute();
                        } catch (PDOException $e) {
                            echo "Erreur Personneconf: " . $e->getMessage() . "<br>";
                        }
                        $conn5->bindParam(':id_piece1', $id_piece1);
                        $conn5->bindParam(':doc_identite', $doc_identite);
                        $conn5->bindParam(':doc_vitale', $doc_vitale);
                        $conn5->bindParam(':doc_mutuelle', $doc_mutuelle);
                        try {
                            $conn5->execute();
                        } catch (PDOException $e) {
                            echo "Erreur PieceJointe: " . $e->getMessage() . "<br>";
                        }
                        $conn6 = $connexion->prepare($sql6);
                        $conn6->bindParam(':id_preadmi1', $id_preadmi1);
                        $conn6->bindParam(':date_hospi', $date_hospi);
                        $conn6->bindParam(':heure', $heure);
                        try {
                            $conn6->execute();
                        } catch (PDOException $e) {
                            echo "Erreur Preadmi: " . $e->getMessage() . "<br>";
                        }
                        $conn7 = $connexion->prepare($sql7);
                        $conn7->bindParam(':id_sociale1', $id_sociale1);
                        $conn7->bindParam(':orga', $orga);
                        $conn7->bindParam(':num_secu', $num_secu);
                        $conn7->bindParam(':assure', $assure);
                        $conn7->bindParam(':ald', $ald);
                        $conn7->bindParam(':nom_mutu', $nom_mutu);
                        $conn7->bindParam(':num_adherent', $num_adherent);
                        $conn7->bindParam(':chambre_part', $chambre_part);
                        try {
                            $conn7->execute();
                        } catch (PDOException $e) {
                            echo "Erreur Sociale: " . $e->getMessage() . "<br>";
                        }
                        $up_sql1 = "UPDATE Hospitalisation SET id_patient = :id_patient1 WHERE id_hospitalisation = :id1;";
                        $up_conn1 = $connexion->prepare($up_sql1);
                        $up_conn1->bindParam(':id_patient1', $id_patient1);
                        $up_conn1->bindParam(':id1', $id1);
                        try {
                            $up_conn1->execute();
                        } catch (PDOException $e) {
                            echo "Erreur Hospitalisation: " . $e->getMessage() . "<br>";
                        }
                        $up_sql2 = "UPDATE Patient SET id_sociale = :id_sociale1, id_perspre = :id_prev1, id_persconf = :id_conf1 WHERE id_patient = :id_patient1;";
                        $up_conn2 = $connexion->prepare($up_sql2);
                        $up_conn2->bindParam(':id_sociale1', $id_sociale1);
                        $up_conn2->bindParam(':id_prev1', $id_prev1);
                        $up_conn2->bindParam(':id_conf1', $id_conf1);
                        $up_conn2->bindParam(':id_patient1', $id_patient1);
                        try {
                            $up_conn2->execute();
                        } catch (PDOException $e) {
                            echo "Erreur Patient: " . $e->getMessage() . "<br>";
                        }
                        $up_sql3 = "UPDATE PieceJointe SET id_patient = :id_patient1 WHERE id = :id_piece1;";
                        $up_conn3 = $connexion->prepare($up_sql3);
                        $up_conn3->bindParam(':id_patient1', $id_patient1);
                        $up_conn3->bindParam(':id_piece1', $id_piece1);
                        try {
                            $up_conn3->execute();
                        } catch (PDOException $e) {
                            echo "Erreur PieceJointe: " . $e->getMessage() . "<br>";
                        }
                        $up_sql4 = "UPDATE Preadmi SET id_medecin = :id_med1, id_patient = :id_patient1 WHERE id = :id_preadmi1;";
                        $up_conn4 = $connexion->prepare($up_sql4);
                        $up_conn4->bindParam(':id_med1', $id_med1);
                        $up_conn4->bindParam(':id_patient1', $id_patient1);
                        $up_conn4->bindParam(':id_preadmi1', $id_preadmi1);
                        try {
                            $up_conn4->execute();
                        } catch (PDOException $e) {
                            echo "Erreur Preadmi: " . $e->getMessage() . "<br>";
                        }
                        $up_sql5 = "UPDATE Sociale SET id_patient = :id_patient1 WHERE id = :id_sociale1;";
                        $up_conn5 = $connexion->prepare($up_sql5);
                        $up_conn5->bindParam(':id_patient1', $id_patient1);
                        $up_conn5->bindParam(':id_sociale1', $id_sociale1);
                        try {
                            $up_conn5->execute();
                        } catch (PDOException $e) {
                            echo "Erreur Sociale: " . $e->getMessage() . "<br>";
                        }
                        echo "<h1>Insertion réussie!</h1>";
                    } catch (PDOException $e) {
                        echo("erreur lors de l'insertion!" . $e->getMessage() . "<br>");
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
