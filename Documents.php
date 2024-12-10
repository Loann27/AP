<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Documents</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        .steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .step {
            text-align: center;
            font-size: 14px;
            color: #3498db;
        }
        .step.active {
            font-weight: bold;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="file"] {
            margin-top: 8px;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="button"] {
            background-color: #bdc3c7;
            color: white;
        }
        button[type="submit"] {
            background-color: #3498db;
            color: white;
        }
        .additional-info {
            margin-top: 30px;
            padding: 20px;
            border-radius: 8px;
            background: #e3f2fd;
            color: #1565c0;
            font-size: 16px;
        }
        .additional-info h2 {
            margin-top: 0;
        }
        .additional-info ul {
            margin: 0;
            padding-left: 20px;
        }
        .additional-info li {
            margin-bottom: 10px;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        .error {
            background-color: #ffebee;
            color: #c62828;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pièces à joindre</h1>
        <div class="steps">
            <div class="step">1<br>HOSPITALISATION</div>
            <div class="step ">2<br>PATIENT</div>
            <div class="step ">3<br>COUVERTURE SOCIALE</div>
            <div class="step active">4<br>DOCUMENTS</div>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uploadsDir = "uploads/";
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'application/pdf'];
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
            $files = ['identity', 'carteVitale', 'mutuelle', 'livretFamille'];
            $errors = [];
            $success = [];

            // Créer le dossier des uploads s'il n'existe pas
            if (!is_dir($uploadsDir)) {
                mkdir($uploadsDir, 0777, true);
            }

            foreach ($files as $fileKey) {
                if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] == 0) {
                    $fileTmpPath = $_FILES[$fileKey]['tmp_name'];
                    $fileName = $_FILES[$fileKey]['name'];
                    $fileMimeType = mime_content_type($fileTmpPath);
                    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                    // Vérification du type MIME et de l'extension
                    if (in_array($fileMimeType, $allowedMimeTypes) && in_array($fileExtension, $allowedExtensions)) {
                        $destination = $uploadsDir . basename($fileName);
                        if (move_uploaded_file($fileTmpPath, $destination)) {
                            $success[] = "Le fichier $fileKey a été téléchargé avec succès.";
                        } else {
                            $errors[] = "Erreur lors du déplacement du fichier pour $fileKey.";
                        }
                    } else {
                        $errors[] = "Le fichier pour $fileKey n'a pas un format valide (seuls PDF, JPG ou PNG sont acceptés).";
                    }
                } elseif (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] != 4) { // 4: Aucun fichier téléchargé
                    $errors[] = "Une erreur est survenue lors du téléchargement du fichier pour $fileKey.";
                }
            }

            // Afficher les messages
            if (!empty($success)) {
                echo '<div class="message">';
                echo implode("<br>", $success);
                echo '</div>';
            }

            if (!empty($errors)) {
                echo '<div class="message error">';
                echo implode("<br>", $errors);
                echo '</div>';
            }
        }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Carte d'identité (recto / verso):</label>
                <input type="file" id="identity" name="identity" accept=".jpg, .png, .pdf" required>
            </div>

            <div class="form-group">
                <label>Carte vitale:</label>
                <input type="file" id="carteVitale" name="carteVitale" accept=".jpg, .png, .pdf" required>
            </div>

            <div class="form-group">
                <label>Carte de mutuelle:</label>
                <input type="file" id="mutuelle" name="mutuelle" accept=".jpg, .png, .pdf" required>
            </div>

            <div class="form-group">
                <label>Livret de famille (pour enfants mineurs):</label>
                <input type="file" id="livretFamille" name="livretFamille" accept=".jpg, .png, .pdf">
            </div>

            <div class="buttons">
                <button type="button" onclick="history.back();">PRÉCÉDENT</button>
                <button type="submit">VALIDER</button>
            </div>
        </form>

        <!-- Section supplémentaire pour les enfants mineurs -->
         <div class="additional-info">
            <h2>Pour les enfants mineurs :</h2>
            <ul>
                <li>Une autorisation de soin et d'opérer signée par les deux représentants légaux</li>
                <li>Le livret de famille</li>
                <li>Ou en cas de monoparentalité, la décision du juge</li>
            </ul>
        </div>
    </div>
</body>
</html>