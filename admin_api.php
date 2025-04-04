<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    echo json_encode(["status" => "error", "message" => "Accès refusé."]);
    exit();
}

// Connexion directe à la base de données
$host = "localhost";       
$dbname = "hopital";  
$username = "root";         
$password = "sio2024";           

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erreur de connexion à la base de données: " . $e->getMessage()]);
    exit();
}

// Vérification de l'action demandée
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === "ajouter_medecin") {
        ajouterMedecin($pdo);
    } elseif ($action === "modifier_medecin") {
        modifierMedecin($pdo);
    } elseif ($action === "supprimer_medecin") {
        supprimerMedecin($pdo);
    } else {
        echo json_encode(["status" => "error", "message" => "Action invalide."]);
    }
}

function ajouterMedecin($pdo) {
    if (!isset($_POST['nom'], $_POST['prenom'], $_POST['identifiant'], $_POST['mdp'], $_POST['id_service'], $_POST['id_role'])) {
        echo json_encode(["status" => "error", "message" => "Données manquantes."]);
        return;
    }

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $identifiant = $_POST['identifiant'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT); // Hash du mot de passe
    $id_service = $_POST['id_service'];
    $id_role = $_POST['id_role'];

    try {
        $sql = "INSERT INTO Professionnel (nom, prenom, identifiant, mdp, id_service, id_role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $identifiant, $mdp, $id_service, $id_role]);

        echo json_encode(["status" => "success", "message" => "Médecin ajouté avec succès."]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erreur: " . $e->getMessage()]);
    }
}

function modifierMedecin($pdo) {
    if (!isset($_POST['id'], $_POST['nom'], $_POST['prenom'], $_POST['identifiant'], $_POST['mdp'], $_POST['id_service'], $_POST['id_role'])) {
        echo json_encode(["status" => "error", "message" => "Données manquantes."]);
        return;
    }

    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $identifiant = $_POST['identifiant'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
    $id_service = $_POST['id_service'];
    $id_role = $_POST['id_role'];

    try {
        $sql = "UPDATE Professionnel SET nom = ?, prenom = ?, identifiant = ?, mdp = ?, id_service = ?, id_role = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $identifiant, $mdp, $id_service, $id_role, $id]);

        echo json_encode(["status" => "success", "message" => "Médecin modifié avec succès."]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erreur: " . $e->getMessage()]);
    }
}

function supprimerMedecin($pdo) {
    if (!isset($_POST['id'])) {
        echo json_encode(["status" => "error", "message" => "ID médecin requis."]);
        return;
    }

    $id = $_POST['id'];

    try {
        $sql = "DELETE FROM Professionnel WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        echo json_encode(["status" => "success", "message" => "Médecin supprimé avec succès."]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erreur: " . $e->getMessage()]);
    }
}
?>
