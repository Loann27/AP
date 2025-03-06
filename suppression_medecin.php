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
    <h1>Bienvenue sur le Panel Admin</h1>

    <section>
        <h2>Gestion rapide</h2>
        <a href="ajout_medecin.php"><button>Ajouter un Médecin</button></a>
        <a href="suppression_medecin.php"><button>Supprimer un Médecin</button></a>
        <a href="../pages/PreAdmi/hospitalisation.php"><button>Ajouter une Pré-admission</button></a>
        <a href="ajout_service.php"><button>Ajouter un Services</button></a>
        <a href="admin_accueil.php"><button>Accueil</button></a>
    </section>
</body>
</html>

<section>
<h2>Supprimer un Médecin</h2>
        <form id="form-suppr-medecin">
            ID Médecin: <input type="number" name="id" required><br>
            <button type="submit">Supprimer</button>
        </form>
</section>