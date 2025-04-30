<!DOCTYPE html>
<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<html>
    <head>
        <title>Page de connexion</title>
        <meta charset="utf-8">
        <link href="css/index.css" rel="stylesheet">
        <script src="js/animation.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body>

        <!-- Ajout du logo -->
        <div id="logo-container">
            <img src="libs/images/LPFS_logo.png" alt="Logo LPFS" class="logo">
        </div>

        <div id="bloc1">
            <h2>connexion</h2>
            <form id="form" method="POST" action="index.php">
                <label for="id">Identifiant: </label>
                <input id="id" name="id" type="text" placeholder="Identifiant" required><br><br>
                <label for="mdp">Mot de passe: </label>
                <input id="mdp" name="mdp" type="password" placeholder="*********" required><br><br>
                <div class="g-recaptcha" data-sitekey="6LcQ5kYqAAAAAHVn08OAS8qAI9rC96as-uehQ9xu"></div><br><br>
                <input type="submit" id="submit" name="submit" value="Connexion">
            </form>
        </div>
        


<h2 id="a">
  <a onclick="return false;" class="typewrite" data-period="2000" data-type='[ "Bienvenue!", "Veuillez-vous connecter afin de pouvoir utiliser notre application.", "Application développée par Loann Piquet et Yohann Boniface"]'>
    <span class="wrap"></span>
  </a>
</h2>


        <?php
        if(isset($_POST["submit"])) {
            if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        
                // Clé secrète du reCAPTCHA
                $secretKey = '6LcQ5kYqAAAAAJ29BvzUfPntr_mDJmeX0k7Cc8lb';  // Mets ici ta clé secrète reCAPTCHA
                
                // Récupérer la réponse de l'utilisateur
                $captchaResponse = $_POST['g-recaptcha-response'];
                
                // Vérifier la réponse auprès des serveurs de Google
                $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captchaResponse");
                $responseKeys = json_decode($response, true);
        
                // Si le reCAPTCHA est validé
                if ($responseKeys["success"]) {
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
            } catch (PDOException $e) {
                echo "Erreur lors de la connexion à la base de donnée : " . $e->getMessage();
            }

            $identifiant = $_POST["id"];
            $mdp_chiff = sha1($_POST["mdp"]);

            $sql2 = "SELECT $donnee2 FROM $table WHERE $donnee2 = :identifiant";
            $stmt2 = $connexion->prepare($sql2);
            $stmt2->bindParam(':identifiant', $identifiant);
            $stmt2->execute();

            if($stmt2->rowCount() == 0) {
                echo "<h1>L'identifiant n'existe pas!</h1>";
            } else {
                $sql = "SELECT * FROM $table WHERE $donnee2 = :identifiant AND $donnee3 = :mdp";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':identifiant', $identifiant);
            $stmt->bindParam(':mdp', $mdp_chiff);
            $stmt->execute();

            if($stmt->rowCount() == 0) {
                echo "<h1>Le mot de passe est incorrect!</h1>";
            } else {
                $sql1 = "SELECT $donnee6 FROM $table WHERE $donnee2 = :identifiant";
                $stmt1 = $connexion->prepare($sql1);
                $stmt1->bindParam(':identifiant', $identifiant);
                $stmt1->execute();
                $result = $stmt1->fetch(PDO::FETCH_ASSOC);
                $_SESSION['test'] = $result['id_role'];

                if($_SESSION['test'] == 1) {
                    $_SESSION['compte'] = $identifiant;
                    $_SESSION['role'] = 'Admin';
                    header('Location: ./pages_admin/admin_accueil.php');
                } else if($_SESSION['test'] == 4) {
                    $_SESSION['compte'] = $identifiant;
                    $_SESSION['role'] = 'Secrétaire';
                    header('Location: ./pages/PreAdmi/accueil_secretaire.php');
                } else if($_SESSION['test'] == 3) {
                    $_SESSION['compte'] = $identifiant;
                    $_SESSION['role'] = 'Médecin';
                    header('Location: ./pages/medecin/accueil.php');
                } else if($_SESSION['test'] == 2) {
                    $_SESSION['compte'] = $identifiant;
                    $_SESSION['role'] = 'Chirurgien';
                    header('Location: ./pages/medecin/accueil.php');
                } else {
                    $_SESSION['compte'] = $identifiant;
                    $_SESSION['role'] = 'Pas admin';
                    header('Location: ./pages/reussi.php');
                }
                
            }
            }

            
                } else {
                    echo "<h1>Veuillez compléter le captcha.</h1>";
                    exit();
                }
            }
        }
        ?>
    </body>
</html>
