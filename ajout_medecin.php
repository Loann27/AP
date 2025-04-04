<?php
session_start();
if ($_SESSION['role'] !== 'Admin') {
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
 
    <!-- Médecins -->
    <section>
        <h2>Ajouter un Médecin</h2>
        <form id="form-ajout-medecin">
            Id Médecin: <input type=number name="id" required><br>
            Nom: <input type="text" name="nom" required><br>
            Prénom: <input type="text" name="prenom" required><br>
            Identifiant : <input type="text" name="identifiant" required><br>
            Mot de passe : <input type="text" name="mdp" required><br>
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

    <script>
        // Fonction pour envoyer les formulaires
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

// Médecins
envoyerFormulaire('form-ajout-medecin', 'ajouter_medecin');
envoyerFormulaire('form-modif-medecin', 'modifier_medecin');
envoyerFormulaire('form-suppr-medecin', 'supprimer_medecin');
</script>
</html>   
