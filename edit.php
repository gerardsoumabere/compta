<?php   
        require 'fonctions.php'; // Inclure le fichier contenant les fonctions
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <a href="index.php"><img
        src="assets\back.svg"
        alt="un crayon"
        height="50px"
        width="50px" /></img></a>
                
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Achats</title>
    <!-- Inclure les fichiers CSS de Bootstrap (à partir d'un CDN) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php   
        include 'formulaire.php';
        if (!empty($_POST)) {
            modifierAchat($_POST["date_achat"], $_POST["magasin"], $_POST["description_achat"], $_POST["montant"], $_POST["acheteur"], $_POST["mode_paiement"]);
        }
    ?>
</body>
</html>