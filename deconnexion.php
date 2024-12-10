<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <title>Déconnexion</title>
        <meta charset="utf-8">
        <link href="../css/index.css" rel="stylesheet">
    </head>
    <body>
        <?php
        session_destroy();
        header("Location: ../");
        exit();
        ?>
    </body>
</html>