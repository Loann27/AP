<?php
session_start();

// Vérification de la session admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    echo json_encode(["status" => "error", "message" => "Accès refusé."]);
    exit();
}

// Connexion à la base de données
$host = "localhost";
$dbname = "hopital";
$username = "root";
$password = "sio2024%";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erreur de connexion à la base de données: " . $e->getMessage()]);
    exit();
}

// Vérification de l'action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action === "ajouter_medecin") {
        ajouterMedecin($pdo);
    } elseif ($action === "modifier_medecin") {
        modifierMedecin($pdo);
    } elseif ($action === "supprimer_medecin") {
        supprimerMedecin($pdo);
    } elseif ($action === "ajouter_service") {
        ajouterService($pdo);
    } elseif ($action === "modifier_service") {
        modifierService($pdo);
    } elseif ($action === "supprimer_service") {
        supprimerService($pdo);
    } else {
        echo json_encode(["status" => "error", "message" => "Action invalide."]);
    }
}

// --- Médecins ---
function ajouterMedecin($pdo) {
    if (!isset($_POST['nom'], $_POST['prenom'], $_POST['identifiant'], $_POST['mdp'], $_POST['id_service'], $_POST['id_role'])) {
        echo json_encode(["status" => "error", "message" => "Données manquantes."]);
        return;
    }

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $identifiant = $_POST['identifiant'];
    $mdp = sha1($_POST['mdp']); // Utilisation du SHA1 comme dans votre table Login
    $id_service = $_POST['id_service'];
    $id_role = $_POST['id_role'];
    
    try {
        // Transaction pour garantir la cohérence
        $pdo->beginTransaction();
        
        // 1. Insérer dans Professionnel
        $sql = "INSERT INTO Professionnel (nom, prenom, identifiant, mdp, id_role, id_service) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $identifiant, $mdp, $id_role, $id_service]);
        
        $pdo->commit();
        echo json_encode(["status" => "success", "message" => "Médecin ajouté avec succès."]);
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(["status" => "error", "message" => "Erreur: " . $e->getMessage()]);
    }
}

function modifierMedecin($pdo) {
    if (!isset($_POST['id'], $_POST['nom'], $_POST['prenom'], $_POST['identifiant'], $_POST['id_service'], $_POST['id_role'])) {
        echo json_encode(["status" => "error", "message" => "Données manquantes."]);
        return;
    }

    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $identifiant = $_POST['identifiant'];
    $id_service = $_POST['id_service'];
    $id_role = $_POST['id_role'];
    
    try {
        // Si un nouveau mot de passe est fourni
        if (!empty($_POST['mdp'])) {
            $mdp = sha1($_POST['mdp']);
            $sql = "UPDATE Professionnel SET nom = ?, prenom = ?, identifiant = ?, 
                   mdp = ?, id_service = ?, id_role = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom, $prenom, $identifiant, $mdp, $id_service, $id_role, $id]);
        } else {
            // Sans changer le mot de passe
            $sql = "UPDATE Professionnel SET nom = ?, prenom = ?, identifiant = ?, 
                   id_service = ?, id_role = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom, $prenom, $identifiant, $id_service, $id_role, $id]);
        }
        
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

// --- Services ---
function ajouterService($pdo) {
    if (!isset($_POST['nom'])) {
        echo json_encode(["status" => "error", "message" => "Nom du service manquant."]);
        return;
    }

    $nom = $_POST['nom'];
    
    try {
        $sql = "INSERT INTO Services (nom) VALUES (?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom]);
        
        echo json_encode(["status" => "success", "message" => "Service ajouté avec succès."]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erreur d'ajout : " . $e->getMessage()]);
    }
}

function modifierService($pdo) {
    if (!isset($_POST['id_service'], $_POST['nom'])) {
        echo json_encode(["status" => "error", "message" => "Données manquantes pour modification."]);
        return;
    }

    $id_service = $_POST['id_service'];
    $nom = $_POST['nom'];
    
    try {
        $sql = "UPDATE Services SET nom = ? WHERE id_service = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $id_service]);
        
        echo json_encode(["status" => "success", "message" => "Service modifié avec succès."]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erreur de modification : " . $e->getMessage()]);
    }
}

function supprimerService($pdo) {
    if (!isset($_POST['id_service'])) {
        echo json_encode(["status" => "error", "message" => "ID service requis."]);
        return;
    }

    $id_service = $_POST['id_service'];
    
    try {
        // Vérifier si le service est utilisé par des professionnels
        $check = $pdo->prepare("SELECT COUNT(*) FROM Professionnel WHERE id_service = ?");
        $check->execute([$id_service]);
        if ($check->fetchColumn() > 0) {
            echo json_encode(["status" => "error", "message" => "Impossible de supprimer ce service : il est associé à des professionnels."]);
            return;
        }
        
        $sql = "DELETE FROM Services WHERE id_service = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_service]);
        
        echo json_encode(["status" => "success", "message" => "Service supprimé avec succès."]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erreur de suppression : " . $e->getMessage()]);
    }
}
?>
