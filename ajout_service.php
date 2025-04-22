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
    <title>Panel Admin - Services - LPFS Clinique</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Gestion des Services</h1>

    <section>
        <h2>Navigation</h2>
        <a href="ajout_medecin.php"><button>Ajouter un Médecin</button></a>
        <a href="suppression_medecin.php"><button>Supprimer un Médecin</button></a>
        <a href="../pages/PreAdmi/hospitalisation.php"><button>Ajouter une Pré-admission</button></a>
        <a href="ajout_service.php"><button>Ajouter un Service</button></a>
        <a href="admin_accueil.php"><button>Accueil</button></a>
    </section>

    <!-- Services -->
    <section>
        <h2>Ajouter un Service</h2>
        <form id="form-ajout-service">
            Nom du service: <input type="text" name="nom" required><br>
            <button type="submit">Ajouter</button>
        </form>

        <h2>Modifier un Service</h2>
        <form id="form-modif-service">
            ID Service: <input type="number" name="id_service" required><br>
            Nouveau Nom: <input type="text" name="nom" required><br>
            <button type="submit">Modifier</button>
        </form>

        <h2>Supprimer un Service</h2>
        <form id="form-suppr-service">
            ID Service: <input type="number" name="id_service" required><br>
            <button type="submit">Supprimer</button>
        </form>
    </section>

    <script>
        async function envoyerFormulaire(formId, action) {
            const form = document.getElementById(formId);
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(form);
                formData.append('action', action);

                try {
                    const response = await fetch('admin_api.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();
                    alert(result.message);
                    form.reset();
                } catch (error) {
                    alert('Erreur lors de la requête.');
                    console.error(error);
                }
            });
        }

        // Appels AJAX pour chaque formulaire
        envoyerFormulaire('form-ajout-service', 'ajouter_service');
        envoyerFormulaire('form-modif-service', 'modifier_service');
        envoyerFormulaire('form-suppr-service', 'supprimer_service');
    </script>
</body>
</html>
