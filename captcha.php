<!DOCTYPE html>
<html>
    <head>
        <title>Page de Captcha</title>
        <meta charset="utf-8">
        <link href="../css/index.css" rel="stylesheet">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body>
        <h1>Page de Captcha</h1>
        <div id="bloc1">
            <form method="POST" action="captcha.php">
                <div class="g-recaptcha" data-sitekey="6LcQ5kYqAAAAAHVn08OAS8qAI9rC96as-uehQ9xu"></div><br><br>
                <input type="submit" id="Verif" name="verif" value="Vérifier">
            </form>
        </div>
    </body>

    <?php
    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        
        // Clé secrète du reCAPTCHA
        $secretKey = '6LcQ5kYqAAAAAJ29BvzUfPntr_mDJmeX0k7Cc8lb';  // Mets ici ta clé secrète reCAPTCHA
        
        // Récupérer la réponse de l'utilisateur
        $captchaResponse = $_POST['g-recaptcha-response'];
        
        // Vérifier la réponse auprès des serveurs de Google
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captchaResponse");
        $responseKeys = json_decode($response, true);

        // Si le reCAPTCHA est validé
        if ($responseKeys["success"]) {
            header('Location: ./reussi.php');
        } else {
            header('Location: ./captcha.php');
            exit();
        }
    }
    ?>
</html>
