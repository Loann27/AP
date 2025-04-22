<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
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
    <h1>Panel Admin - Suppression d’un Médecin</h1>

    <section>
        <h2>Navigation rapide</h2>
        <a href="ajout_medecin.php"><button>Ajouter un Médecin</button></a>
        <a href="suppression_medecin.php"><button>Supprimer un Médecin</button></a>
        <a href="../pages/PreAdmi/hospitalisation.php"><button>Ajouter une Pré-admission</button></a>
        <a href="ajout_service.php"><button>Ajouter un Service</button></a>
        <a href="admin_accueil.php"><button>Accueil</button></a>
    </section>

    <section>
        <h2>Supprimer un Médecin</h2>
        <form id="form-suppr-medecin">
            ID Médecin: <input type="number" name="id" required><br>
            <button type="submit">Supprimer</button>
        </form>
    </section>

    <script>
        document.getElementById('form-suppr-medecin').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            formData.append('action', 'supprimer_medecin');

            try {
                const response = await fetch('admin_api.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                alert(result.message);
                form.reset(); // Réinitialise le formulaire
            } catch (error) {
                alert("Erreur lors de la suppression.");
                console.error(error);
            }
        });
    </script>
</body>
</html>
