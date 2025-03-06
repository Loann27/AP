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
        <h2>Gestion</h2>
        <a href="ajout_medecin.php"><button>Ajouter un Médecin</button></a>
        <a href="suppression_medecin.php"><button>Supprimer un Médecin</button></a>
        <a href="../pages/PreAdmi/hospitalisation.php"><button>Ajouter une Pré-admission</button></a>
        <a href="ajout_service.php"><button>Ajouter un Services</button></a>
    </section>
</body>
</html>
    <!-- JS -->
    <script>
        async function envoyerFormulaire(formId, action) {
            const form = document.getElementById(formId);
            form.addEventListener('submit', async (e) => {
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
                } catch (error) {
                    alert('Erreur lors de la requête.');
                }
            });
        }

        // Pré-admission
        envoyerFormulaire('form-preadmi', 'ajouter_preadmi');

        // Services
        envoyerFormulaire('form-ajout-service', 'ajouter_service');
        envoyerFormulaire('form-modif-service', 'modifier_service');
        envoyerFormulaire('form-suppr-service', 'supprimer_service');

        // Médecins
        envoyerFormulaire('form-ajout-medecin', 'ajouter_medecin');
        envoyerFormulaire('form-modif-medecin', 'modifier_medecin');
        envoyerFormulaire('form-suppr-medecin', 'supprimer_medecin');
    </script>
</body>
</html>
