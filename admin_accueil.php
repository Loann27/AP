<?php
session_start();
 if ($_SESSION['role'] != 'Admin') {
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
        <a href="../pages/PreAdmi/modif.php"><button>Modifier une Pré-admission</button></a>
        <a href="../pages/PreAdmi/suppr.php"><button>Supprimer une Pré-admission</button></a>
    </section>

    <section>
        <h2>Liste des Preadmissions</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date de Preadmission</th>
                <th>Fichier PDF</th>
            </tr>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nom']) ?></td>
                    <td><?= htmlspecialchars($row['prenom']) ?></td>
                    <td><?= htmlspecialchars($row['date_preadmission']) ?></td>
                    <td>
                        <?php if (!empty($row['pdf_path']) && file_exists($row['pdf_path'])) { ?>
                            <a href="<?= $row['pdf_path'] ?>" target="_blank">
                                <button>Télécharger PDF</button>
                            </a>
                        <?php } else { ?>
                            Non disponible
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
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
