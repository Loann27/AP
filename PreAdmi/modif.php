<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <title>Mettre à jour la pré-admission</title>
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
            $select = "SELECT Professionnel.nom AS nom_medecin, Professionnel.prenom AS prenom_medecin, Services.nom AS nom_service FROM Professionnel INNER JOIN Services ON Professionnel.id_service = Services.id_service WHERE Professionnel.id_role IN (2, 3);";
            $select_res = $connexion->prepare($select);
            $select_res->execute();

            $select2 = "SELECT Preadmi.id AS id_preadmi, Patient.prenom AS prenom_patient, Patient.nom_naissance AS nom_patient, Patient.nom_epouse AS new_nom_patient, Professionnel.nom AS nom_medecin, Professionnel.prenom AS prenom_medecin FROM Preadmi INNER JOIN Patient ON Preadmi.id_patient = Patient.id_patient INNER JOIN Professionnel ON Preadmi.id_medecin = Professionnel.id;";
            $select_res2 = $connexion->prepare($select2);
            $select_res2->execute();
            if(($_SESSION['role'] == 'Secrétaire') || ($_SESSION['role'] == "Admin")) {
                ?>
                <div id='bloc1'>
                    <h1>Formulaire Pré-Admission</h1>
                    <form id="myForm" method="POST" action="modif.php" enctype="multipart/form-data">
                        <label for=""></label>
                        <select id="modification" name="modification" required>
                            <option value="">Choisir la pré-admission</option>
                            <?php
                            if($select_res2->rowCount() > 0) {
                                while($row = $select_res2->fetch(PDO::FETCH_ASSOC)) {
                                    if($row['new_nom_patient'] === NULL) {
                                        echo '<option value="' . $row['id_preadmi'] . '">' . $row['prenom_patient'] . ' ' . $row['nom_patient'] . ' avec ' . $row['prenom_medecin'] . ' ' . $row['nom_medecin'];
                                    } else {
                                        echo '<option value="' . $row['id_preadmi'] . '">' . $row['prenom_patient'] . ' ' . $row['nom_patient'] . ' ' . $row['new_nom_patient'] . ' avec ' . $row['prenom_medecin'] . ' ' . $row['nom_medecin'];
                                    }
                                }
                            }
                            ?>
                        </select>
                        <label for='preadmi'>Pré-admission pour:*</label>
                        <select name='preadmi' id='preadmi'>
                            <option value=''>Choix</option>
                            <option value='Ambulatoire chirurgie'>Ambulatoire chirurgie</option>
                            <option value='Hospitalisation'>Hospitalisation (au moins une nuit)</option>
                        </select><br><br>
                        <label for='date_hospi'>Date hospitalisation:* </label>
                        <input class="input" id='date_hospi' name='date_hospi' type='date' onchange='verif()'><br/>
                        <label for='heure'>Heure de l'intervention (7:00 - 16:30):* </label>
                        <input class="input" id='heure' name='heure' type='time' placeholder='--:--' onchange='verif_time(this.value)'><br><br>
                        <label for='medecin'>Nom du médecin*</label><br>
                        <select name='medecin' id='medecin'>
                            <option value=''>Choix</option>
                            <?php
                            if ($select_res->rowCount() > 0) {
                                while ($row = $select_res->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="' . $row['nom_medecin'] . '">' . $row['prenom_medecin'] . ' ' . $row['nom_medecin'] . ' (' . $row['nom_service'] . ') ' . '</option>';
                                }
                            }
                            ?>
                        </select><br><br>
                        <h1>Informations concernant le patient</h1>
                        <label for='civ'>Civ. </label>
                        <select name='civ' id='civ'>
                            <option value=''>Choix</option>
                            <option value='Homme'>Homme</option>
                            <option value='Femme'>Femme</option>
                        </select><br/>
                        <label for='nom_naissance'>Nom de naissance </label>
                        <input id='nom_naissance' name='nom_naissance' type='text'><br/>
                        <label for='nom_epouse'>Nom d'épouse </label>
                        <input id='nom_epouse' name='nom_epouse' type='text'><br><br>
                        <label for='prenom'>Prénom </label>
                        <input type='text' id='prenom' name='prenom'><br/>
                        <label for='date_naissance'>Date de naissance </label>
                        <input type='date' id='date_naissance' name='date_naissance'><br><br>
                        <label for='adresse'>Adresse </label>
                        <input type='text' id='adresse' name='adresse'><br><br>
                        <label for='cp'>Code Postal </label>
                        <input type='tel' id='cp' name='cp' pattern='[0-9]{5}'><br/>
                        <label for='ville'>Ville </label>
                        <input type='text' id='ville' name='ville'><br><br>
                        <label for='email'>Email (.com, .fr, .en, .net, .co.uk)</label>
                        <input class="input" type='mail' id='email' name='email' onchange="verif_patients()"><br/><br/>
                        <label for='telephone'>Téléphone </label>
                        <input type='tel' id='telephone' name='telephone' pattern='[0-9]{10}'><br><br>
                        <h1>Coordonnées personne à prévenir</h1>
                        <label for='nom_prev'>Nom </label>
                        <input type='text' name='nom_prev' id='nom_prev'><br/>
                        <label for='pren_prev'>Prénom </label>
                        <input type='text' name='pren_prev' id='pren_prev'><br/>
                        <label for='tel_prev'>Téléphone </label>
                        <input class="input" type='tel' name='tel_prev' id='tel_prev' pattern='[0-9]{10}' onchange="verif_prevenir()"><br/>
                        <label for='adr_prev'>Adresse</label>
                        <input type='text' name='adr_prev' id='adr_prev'><br/>
                        <h1>Coordonnées personne de confiance</h1>
                        <label for='nom_conf'>Nom </label>
                        <input type='text' name='nom_conf' id='nom_conf'><br/>
                        <label for='pren_conf'>Prénom </label>
                        <input type='text' name='pren_conf' id='pren_conf'><br/>
                        <label for='tel_conf'>Téléphone </label>
                        <input class="input" type='tel' name='tel_conf' id='tel_conf' pattern='[0-9]{10}' onchange="verif_confiance()"><br/>
                        <label for='adr_conf'>Adresse</label>
                        <input type='text' name='adr_conf' id='adr_conf'><br/><br/>
                        <h1>Couverture Sociale</h1>
                        <label for='orga'>Organisme de sécurité sociale / Nom de la caisse d'assurance maladie* </label>
                        <input type='text' name='orga' id='orga' placeholder='Ex: CPAM du Tarn et Garonne, CPAM du Lot, RSI, MSA...'><br/>
                        <label for='num_secu'>Numéro de sécurité sociale* </label>
                        <input class="input" type='tel' name='num_secu' id='num_secu' pattern='[0-9]{15}' onchange="verif_num_secu()"><br/>
                        <label for='assure'>Le patient est-il assuré?* </label>
                        <select name='assure' id='assure'>
                            <option value=''>Choix</option>
                            <option value='oui'>Oui</option>
                            <option value='non'>Non</option>
                        </select><br/>
                        <label for='ald'>Le patient est-il ALD?* </label>
                        <select name='ald' id='ald'>
                            <option value=''>Choix</option>
                            <option value='oui'>Oui</option>
                            <option value='non'>Non</option>
                        </select><br/>
                        <label for='nom_mutu'>Nom de la mutuelle ou de l'assurance* </label>
                        <input type='text' name='nom_mutu' id='nom_mutu'><br/>
                        <label for='num_adherent'>Numéro adhérent* </label>
                        <input type='tel' name='num_adherent' id='num_adherent'><br/>
                        <label for='chambre_part'>Chambre particulière?* </label>
                        <select name='chambre_part' id='chambre_part'>
                            <option value=''>Choix</option>
                            <option value='oui'>Oui</option>
                            <option value='non'>Non</option>
                        </select><br/><br/>
                        <h1>Documents</h1>
                        <label for='identity'>Carte d'identité (recto / verso):</label>
                        <input type='file' id='identity' name="identity" accept='.jpg, .png, .pdf'><br/>
                        <label for='carteVitale'>Carte vitale:</label>
                        <input type='file' id='carteVitale' name="carteVitale" accept='.jpg, .png, .pdf'><br/>
                        <label for='mutuelle'>Carte de mutuelle:</label>
                        <input type='file' id='mutuelle' name='mutuelle' accept='.jpg, .png, .pdf'><br/>
                        <label for='livretFamille'>Livret de famille (pour enfants mineurs):</label>
                        <input type='file' id='livretFamille' name='livretFamille' accept='.jpg, .png, .pdf'><br/>
                        <input type='submit' name='submit' id='submit' value='Modifier'>
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
                        <a href="../accueil_admin.php"><input type='submit' value='RETOUR'></a>
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
                        $id_preadmi = $_POST['modification'];
                        $preadmi = isset($_POST['preadmi']) ? $_POST["preadmi"] : null;
                        $date_hospi = isset($_POST['date_hospi']) ? $_POST["date_hospi"] : null;
                        $heure = isset($_POST['heure']) ? $_POST["heure"] : null;
                        $medecin = isset($_POST['medecin']) ? $_POST["medecin"] : null;
                        $civ = isset($_POST['civ']) ? $_POST["civ"] : null;
                        $nom_nais = isset($_POST['nom_naissance']) ? $_POST["nom_naissance"] : null;
                        $nom_ep = isset($_POST['nom_epouse']) ? $_POST["nom_epouse"] : null;
                        $pren = isset($_POST['prenom']) ? $_POST["prenom"] : null;
                        $date_nais = isset($_POST['date_naissance']) ? $_POST["date_naissance"] : null;
                        $adr = isset($_POST['adresse']) ? $_POST["adresse"] : null;
                        $cp = isset($_POST['cp']) ? $_POST["cp"] : null;
                        $ville = isset($_POST['ville']) ? $_POST["ville"] : null;
                        $email = isset($_POST['email']) ? $_POST["email"] : null;
                        $tel = isset($_POST['telephone']) ? $_POST["telephone"] : null;
                        $nom_prev = isset($_POST['nom_prev']) ? $_POST["nom_prev"] : null;
                        $pren_prev = isset($_POST['pren_prev']) ? $_POST["pren_prev"] : null;
                        $tel_prev = isset($_POST['tel_prev']) ? $_POST["tel_prev"] : null;
                        $adr_prev = isset($_POST['adr_prev']) ? $_POST["adr_prev"] : null;
                        $nom_conf = isset($_POST['nom_conf']) ? $_POST["nom_conf"] : null;
                        $pren_conf = isset($_POST['pren_conf']) ? $_POST["pren_conf"] : null;
                        $tel_conf = isset($_POST['tel_conf']) ? $_POST["tel_conf"] : null;
                        $adr_conf = isset($_POST['adr_conf']) ? $_POST["adr_conf"] : null;
                        $orga = isset($_POST['orga']) ? $_POST["orga"] : null;
                        $num_secu = isset($_POST['num_secu']) ? $_POST["num_secu"] : null;
                        $assure = isset($_POST['assure']) ? $_POST["assure"] : null;
                        $ald = isset($_POST['ald']) ? $_POST["ald"] : null;
                        $nom_mutu = isset($_POST['nom_mutu']) ? $_POST["nom_mutu"] : null;
                        $num_adherent = isset($_POST['num_adherent']) ? $_POST["num_adherent"] : null;
                        $chambre_part = isset($_POST['chambre_part']) ? $_POST["chambre_part"] : null;
                        if(isset($_FILES['identity']) && $_FILES['identity']['size'] > 0) {
                            $mimeIdentite = mime_content_type($_FILES['identity']['tmp_name']);
                            $fileIdentite = file_get_contents($_FILES['identity']['tmp_name']);
                            $baseIdentite = base64_encode($fileIdentite);
                            $doc_identite = 'data:' . $mimeIdentite . ';base64,' . $baseIdentite;
                            $up_sql32 = "UPDATE PieceJointe SET recto_verso_identite = :identite INNER JOIN Patient ON Patient.id_patient = PieceJointe.id_patient INNER JOIN Preadmi ON Patient.id_patient = Preadmi.id_patient WHERE Preadmi.id = :id";
                            $conn32 = $connexion->prepare($up_sql32);
                            $conn32->bindParam(':identite', $doc_identite);
                            $conn32->bindParam(':id', $id_preadmi);
                            $conn32->execute();
                        }
                        if(isset($_FILES['carteVitale']) && $_FILES['carteVitale']['size'] > 0) {
                            $mimeVitale = mime_content_type($_FILES['carteVitale']['tmp_name']);
                            $fileVitale = file_get_contents($_FILES['carteVitale']['tmp_name']);
                            $baseVitale = base64_encode($fileVitale);
                            $doc_vitale = 'data:' . $mimeVitale . ';base64,' . $baseVitale;
                            $up_sql33 = "UPDATE PieceJointe SET carte_vitale = :carteVitale INNER JOIN Patient ON Patient.id_patient = PieceJointe.id_patient INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn33 = $connexion->prepare($up_sql33);
                            $conn33->bindParam(':carteVitale', $doc_vitale);
                            $conn33->bindParam(':id', $id_preadmi);
                            $conn33->execute();
                        }
                        if(isset($_FILES['mutuelle']) && $_FILES['mutuelle']['size'] > 0) {
                            $mimeMutuelle = mime_content_type($_FILES['mutuelle']['tmp_name']);
                            $fileMutuelle = file_get_contents($_FILES['mutuelle']['tmp_name']);
                            $baseMutuelle = base64_encode($fileMutuelle);
                            $doc_mutuelle = 'data:' . $mimeMutuelle . ';base64,' . $baseMutuelle;
                            $up_sql34 = "UPDATE PieceJointe SET carte_mutuelle = :mutuelle INNER JOIN Patient ON Patient.id_patient = PieceJointe.id_patient INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn34 = $connexion->prepare($up_sql34);
                            $conn34->bindParam(':mutuelle', $doc_mutuelle);
                            $conn34->bindParam(':id', $id_preadmi);
                            $conn34->execute();
                        }
                        if(isset($_FILES['livretFamille']) && $_FILES['livretFamille']['size'] > 0) {
                            $mimeLivret = mime_content_type($_FILES['livretFamille']['tmp_name']);
                            $fileLivret = file_get_contents($_FILES['livretFamille']['tmp_name']);
                            $baseLivret = base64_encode($fileLivret);
                            $doc_livret = 'data:' . $mimeLivret . ';base64,' . $baseLivret;
                            $up_sql35 = "UPDATE PieceJointe SET livret_famille = :livretFamille INNER JOIN Patient ON Patient.id_patient = PieceJointe.id_patient INNER JOIN Preadmi ON Patient.id_patient = Preadmi.id_patient WHERE Preadmi.id = :id";
                            $conn35 = $connexion->prepare($up_sql35);
                            $conn35->bindParam(':livretFamille', $doc_livret);
                            $conn35->bindParam(':id', $id_preadmi);
                            $conn35->execute();
                        }
                        if(isset($_POST['preadmi']) && !empty($_POST['preadmi'])) {
                            $up_sql1 = "UPDATE Preadmi SET type_preadmi = :preadmi WHERE id = :id";
                            $conn1 = $connexion->prepare($up_sql1);
                            $conn1->bindParam(':preadmi', $preadmi);
                            $conn1->bindParam(':id', $id_preadmi);
                            $conn1->execute();
                        }
                        if(isset($_POST['date_hospi']) && !empty($_POST['date_hospi'])) {
                            $up_sql2 = "UPDATE Preadmi SET date_preadmi = :date_preadmi WHERE id = :id";
                            $conn2 = $connexion->prepare($up_sql2);
                            $conn2->bindParam(':date_preadmi', $date_hospi);
                            $conn2->bindParam(':id', $id_preadmi);
                            $conn2->execute();
                            $up_sql3 = "UPDATE Hospitalisation SET date_hospi = :date_hospi INNER JOIN Patient ON Hospitalisation.id_patient = Patient.id_patient INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn3 = $connexion->prepare($up_sql3);
                            $conn3->bindParam(':date_hospi', $date_hospi);
                            $conn3->bindParam(':id', $id_preadmi);
                            $conn3->execute();
                        }
                        if(isset($_POST['heure']) && !empty($_POST['heure'])) {
                            $up_sql4 = "UPDATE Preadmi SET heure = :heure WHERE id = :id";
                            $conn4 = $connexion->prepare($up_sql4);
                            $conn4->bindParam(':heure', $heure);
                            $conn4->bindParam(':id', $id_preadmi);
                            $conn4->execute();
                        }
                        if (isset($_POST['medecin']) && !empty($_POST['medecin'])) {
                            $id_medecin = "SELECT id FROM Professionnel WHERE nom = :medecin;";
                            $id_med = $connexion->prepare($id_medecin);
                            $id_med->bindParam(':medecin', $medecin);
                            $id_med->execute();
                            $up_sql5 = "UPDATE Hospitalisation SET nom_medecin = :medecin INNER JOIN Patient ON Hospitalisation.id_patient = Patient.id_patient INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn5 = $connexion->prepare($up_sql5);
                            $conn5->bindParam(':medecin', $medecin);
                            $conn5->bindParam(':id', $id_preadmi);
                            $conn5->execute();
                            $up_sql6 = "UPDATE Preadmi SET id_medecin = :id_medecin WHERE id = :id";
                            $conn6 = $connexion->prepare($up_sql6);
                            $conn6->bindParam(':id_medecin', $id_med['id']);
                            $conn6->bindParam(':id', $id_preadmi);
                            $conn6->execute();
                        }
                        
                        if (isset($_POST['civ']) && !empty($_POST['civ'])) {
                            $up_sql7 = "UPDATE Patient SET genre = :civ INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn7 = $connexion->prepare($up_sql7);
                            $conn7->bindParam(':civ', $civ);
                            $conn7->bindParam(':id', $id_preadmi);
                            $conn7->execute();
                        }
                        
                        if (isset($_POST['nom_naissance']) && !empty($_POST['nom_naissance'])) {
                            $up_sql8 = "UPDATE Patient SET nom_naissance = :nom_nais INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn8 = $connexion->prepare($up_sql8);
                            $conn8->bindParam(':nom_nais', $nom_nais);
                            $conn8->bindParam(':id', $id_preadmi);
                            $conn8->execute();
                        }
                        
                        if (isset($_POST['nom_epouse']) && !empty($_POST['nom_epouse'])) {
                            $up_sql9 = "UPDATE Patient SET nom_epouse = :nom_ep INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn9 = $connexion->prepare($up_sql9);
                            $conn9->bindParam(':nom_ep', $nom_ep);
                            $conn9->bindParam(':id', $id_preadmi);
                            $conn9->execute();
                        }
                        
                        if (isset($_POST['prenom']) && !empty($_POST['prenom'])) {
                            $up_sql10 = "UPDATE Patient SET prenom = :prenom INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn10 = $connexion->prepare($up_sql10);
                            $conn10->bindParam(':prenom', $pren);
                            $conn10->bindParam(':id', $id_preadmi);
                            $conn10->execute();
                        }
                        
                        if (isset($_POST['date_naissance']) && !empty($_POST['date_naissance'])) {
                            $up_sql11 = "UPDATE Patient SET date_naissance = :date_nais INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn11 = $connexion->prepare($up_sql11);
                            $conn11->bindParam(':date_nais', $date_nais);
                            $conn11->bindParam(':id', $id_preadmi);
                            $conn11->execute();
                        }
                        
                        if (isset($_POST['adresse']) && !empty($_POST['adresse'])) {
                            $up_sql12 = "UPDATE Patient SET adresse = :adresse INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn12 = $connexion->prepare($up_sql12);
                            $conn12->bindParam(':adresse', $adr);
                            $conn12->bindParam(':id', $id_preadmi);
                            $conn12->execute();
                        }
                        
                        if (isset($_POST['cp']) && !empty($_POST['cp'])) {
                            $up_sql13 = "UPDATE Patient SET CP = :cp INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn13 = $connexion->prepare($up_sql13);
                            $conn13->bindParam(':cp', $cp);
                            $conn13->bindParam(':id', $id_preadmi);
                            $conn13->execute();
                        }
                        
                        if (isset($_POST['ville']) && !empty($_POST['ville'])) {
                            $up_sql14 = "UPDATE Patient SET ville = :ville INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn14 = $connexion->prepare($up_sql14);
                            $conn14->bindParam(':ville', $ville);
                            $conn14->bindParam(':id', $id_preadmi);
                            $conn14->execute();
                        }
                        
                        if (isset($_POST['email']) && !empty($_POST['email'])) {
                            $up_sql15 = "UPDATE Patient SET email = :email INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn15 = $connexion->prepare($up_sql15);
                            $conn15->bindParam(':email', $email);
                            $conn15->bindParam(':id', $id_preadmi);
                            $conn15->execute();
                        }
                        
                        if (isset($_POST['telephone']) && !empty($_POST['telephone'])) {
                            $up_sql16 = "UPDATE Patient SET telephone = :tel INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn16 = $connexion->prepare($up_sql16);
                            $conn16->bindParam(':tel', $tel);
                            $conn16->bindParam(':id', $id_preadmi);
                            $conn16->execute();
                        }
                        
                        if (isset($_POST['nom_prev']) && !empty($_POST['nom_prev'])) {
                            $up_sql17 = "UPDATE Personnepre SET Personnepre.nom = :nom_prev INNER JOIN Patient ON Patient.id_perspre = Personnepre.id INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn17 = $connexion->prepare($up_sql17);
                            $conn17->bindParam(':nom_prev', $nom_prev);
                            $conn17->bindParam(':id', $id_preadmi);
                            $conn17->execute();
                        }
                        
                        if (isset($_POST['pren_prev']) && !empty($_POST['pren_prev'])) {
                            $up_sql18 = "UPDATE Personnepre SET Personnepre.prenom = :pren_prev INNER JOIN Patient ON Patient.id_perspre = Personnepre.id INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn18 = $connexion->prepare($up_sql18);
                            $conn18->bindParam(':pren_prev', $pren_prev);
                            $conn18->bindParam(':id', $id_preadmi);
                            $conn18->execute();
                        }
                        
                        if (isset($_POST['tel_prev']) && !empty($_POST['tel_prev'])) {
                            $up_sql19 = "UPDATE Personnepre SET Personnepre.tel = :tel_prev INNER JOIN Patient ON Patient.id_perspre = Personnepre.id INNER JOIN Preadmi ON Preadmi.id_patient = Patient.id_patient WHERE Preadmi.id = :id";
                            $conn19 = $connexion->prepare($up_sql19);
                            $conn19->bindParam(':tel_prev', $tel_prev);
                            $conn19->bindParam(':id', $id_preadmi);
                            $conn19->execute();
                        }
                        
                        if (isset($_POST['adr_prev']) && !empty($_POST['adr_prev'])) {
                            $up_sql20 = "UPDATE Personnepre SET Personnepre.adresse = :adr_prev INNER JOIN Patient ON Patient.id_perspre = Personnepre.id INNER JOIN Preadmi ON Patient.id_patient = Preadmi.id_patient WHERE Preadmi.id = :id";
                            $conn20 = $connexion->prepare($up_sql20);
                            $conn20->bindParam(':adr_prev', $adr_prev);
                            $conn20->bindParam(':id', $id_preadmi);
                            $conn20->execute();
                        }
                        
                        if (isset($_POST['nom_conf']) && !empty($_POST['nom_conf'])) {
                            $up_sql21 = "UPDATE Personneconf SET Personneconf.nom = :nom_conf INNER JOIN Patient ON Patient.id_persconf = Personneconf.id INNER JOIN Preadmi ON Patient.id_patient = Preadmi.id_patient WHERE Preadmi.id = :id";
                            $conn21 = $connexion->prepare($up_sql21);
                            $conn21->bindParam(':nom_conf', $nom_conf);
                            $conn21->bindParam(':id', $id_preadmi);
                            $conn21->execute();
                        }
                        
                        if (isset($_POST['pren_conf']) && !empty($_POST['pren_conf'])) {
                            $up_sql22 = "UPDATE Personneconf SET Personneconf.prenom = :pren_conf INNER JOIN Patient ON Patient.id_persconf = Personneconf.id INNER JOIN Preadmi ON Patient.id_patient = Preadmi.id_patient WHERE Preadmi.id = :id";
                            $conn22 = $connexion->prepare($up_sql22);
                            $conn22->bindParam(':pren_conf', $pren_conf);
                            $conn22->bindParam(':id', $id_preadmi);
                            $conn22->execute();
                        }
                        
                        if (isset($_POST['tel_conf']) && !empty($_POST['tel_conf'])) {
                            $up_sql23 = "UPDATE Personneconf SET Personneconf.tel = :tel_conf INNER JOIN Patient ON Patient.id_persconf = Personneconf.id INNER JOIN Preadmi ON Patient.id_patient = Preadmi.id_patient WHERE Preadmi.id = :id";
                            $conn23 = $connexion->prepare($up_sql23);
                            $conn23->bindParam(':tel_conf', $tel_conf);
                            $conn23->bindParam(':id', $id_preadmi);
                            $conn23->execute();
                        }
                        
                        if (isset($_POST['adr_conf']) && !empty($_POST['adr_conf'])) {
                            $up_sql24 = "UPDATE Personneconf SET Personneconf.adresse = :adr_conf INNER JOIN Patient ON Patient.id_persconf = Personneconf.id INNER JOIN Preadmi ON Patient.id_patient = Preadmi.id_patient WHERE Preadmi.id = :id";
                            $conn24 = $connexion->prepare($up_sql24);
                            $conn24->bindParam(':adr_conf', $adr_conf);
                            $conn24->bindParam(':id', $id_preadmi);
                            $conn24->execute();
                        }
                        
                        if (isset($_POST['orga']) && !empty($_POST['orga'])) {
                            $up_sql25 = "UPDATE Sociale SET organisme_secu_sociale = :orga INNER JOIN Patient ON Patient.id_sociale = Sociale.id INNER JOIN Preadmi ON Patient.id_patient = Preadmi.id_patient WHERE Preadmi.id = :id";
                            $conn25 = $connexion->prepare($up_sql25);
                            $conn25->bindParam(':orga', $orga);
                            $conn25->bindParam(':id', $id_preadmi);
                            $conn25->execute();
                        }
                        
                        if (isset($_POST['num_secu']) && !empty($_POST['num_secu'])) {
                            $up_sql26 = "UPDATE Sociale SET num_secu = :num_secu INNER JOIN Patient ON Patient.id_sociale = Sociale.id INNER JOIN Preadmi ON Patient.id_patient = Preadmi.id_patient WHERE Preadmi.id = :id";
                            $conn26 = $connexion->prepare($up_sql26);
                            $conn26->bindParam(':num_secu', $num_secu);
                            $conn26->bindParam(':id', $id_preadmi);
                            $conn26->execute();
                        }
                        
                        if (isset($_POST['assure']) && !empty($_POST['assure'])) {
                            $up_sql27 = "UPDATE Sociale SET assure = :assure INNER JOIN Patient ON Patient.id_sociale = Sociale.id INNER JOIN Preadmi ON Patient.id_patient = Preadmi.id_patient WHERE Preadmi.id = :id";
                            $conn27 = $connexion->prepare($up_sql27);
                            $conn27->bindParam(':assure', $assure);
                            $conn27->bindParam(':id', $id_preadmi);
                            $conn27->execute();
                        }
                        
                        if (isset($_POST['ald']) && !empty($_POST['ald'])) {
                            $up_sql28 = "UPDATE Sociale SET ald = :ald INNER JOIN Patient ON Patient.id_sociale = Sociale.id INNER JOIN Preadmi ON Patient.id_patient = Preadmi.id_patient WHERE Preadmi.id = :id";
                            $conn28 = $connexion->prepare($up_sql28);
                            $conn28->bindParam(':ald', $ald);
                            $conn28->bindParam(':id', $id);
                            $conn28->execute();
                        }
                        
                        if (isset($_POST['nom_mutu']) && !empty($_POST['nom_mutu'])) {
                            $up_sql29 = "UPDATE Sociale SET nom_mutuelle = :nom_mutu INNER JOIN Patient ON Patient.id_sociale = Sociale.id INNER JOIN Preadmi ON Patient.id_patient = Preadmi.id_patient WHERE Preadmi.id = :id";
                            $conn29 = $connexion->prepare($up_sql29);
                            $conn29->bindParam(':nom_mutu', $nom_mutu);
                            $conn29->bindParam(':id', $id_preadmi);
                            $conn29->execute();
                        }
                        
                        if (isset($_POST['num_adherent']) && !empty($_POST['num_adherent'])) {
                            $up_sql30 = "UPDATE Sociale SET num_adherent = :num_adherent INNER JOIN Patient ON Patient.id_sociale = Sociale.id INNER JOIN Preadmi ON Patient.id_patient = Preadmi.id_patient WHERE Preadmi.id = :id";
                            $conn30 = $connexion->prepare($up_sql30);
                            $conn30->bindParam(':num_adherent', $num_adherent);
                            $conn30->bindParam(':id', $id_preadmi);
                            $conn30->execute();
                        }
                        
                        if (isset($_POST['chambre_part']) && !empty($_POST['chambre_part'])) {
                            $up_sql31 = "UPDATE Sociale SET chambre_particuliere = :chambre_part INNER JOIN Patient ON Patient.id_sociale = Sociale.id INNER JOIN Preadmi ON Patient.id_patient = Preadmi.id_patient WHERE Preadmi.id = :id";
                            $conn31 = $connexion->prepare($up_sql31);
                            $conn31->bindParam(':chambre_part', $chambre_part);
                            $conn31->bindParam(':id', $id_preadmi);
                            $conn31->execute();
                        }
                        echo "<h1>Mise à jour réussie!</h1>";
                    } catch (PDOException $e) {
                        echo("erreur lors de la mise à jour!" . $e->getMessage() . "<br>");
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
