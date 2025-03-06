<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../../');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - LPFS Clinique</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Ajout et modification des médecins</h1>

    <section>
        
        <a href="ajout_medecin.php"><button>Ajouter un Médecin</button></a>
        <a href="suppression_medecin.php"><button>Supprimer un Médecin</button></a>
        <a href="../pages/PreAdmi/hospitalisation.php"><button>Ajouter une Pré-admission</button></a>
        <a href="ajout_service.php"><button>Ajouter un Services</button></a>
        <a href="admin_accueil.php"><button>Accueil</button></a>
    </section>
</body>
</html>    
    <!-- Médecins -->
    <section>
        <h2>Ajouter un Médecin</h2>
        <form id="form-ajout-medecin">
            Nom: <input type="text" name="nom" required><br>
            Prénom: <input type="text" name="prenom" required><br>
            Identifiant: <input type="text" name="identifiant" required><br>
            Mot de passe (hashé): <input type="text" name="mdp" required><br>
            ID Service: <input type="number" name="id_service" required><br>
            ID Rôle: <input type="number" name="id_role" required><br>
            <button type="submit">Ajouter</button>
        </form>

        <h2>Modifier un Médecin</h2>
        <form id="form-modif-medecin">
            ID Médecin: <input type="number" name="id" required><br>
            Nom: <input type="text" name="nom" required><br>
            Prénom: <input type="text" name="prenom" required><br>
            Identifiant: <input type="text" name="identifiant" required><br>
            Mot de passe (hashé): <input type="text" name="mdp" required><br>
            ID Service: <input type="number" name="id_service" required><br>
            ID Rôle: <input type="number" name="id_role" required><br>
            <button type="submit">Modifier</button>
        </form>

        
    </section>