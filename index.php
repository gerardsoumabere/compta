<?php
require 'fonctions.php'; // Inclure le fichier contenant les fonctions
require 'utils.php'; // Inclure le fichier contenant les outils génériques


$achats = getAchats();
$total_mois = totalMois();

if (!empty($_POST)) {
    ajouterAchat($_POST["date_achat"], $_POST["magasin"], $_POST["description_achat"], $_POST["montant"], $_POST["acheteur"], $_POST["mode_paiement"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Achats</title>
    <!-- Inclure les fichiers CSS de Bootstrap (à partir d'un CDN) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1>Gestion des Achats</h1>
    
    <h2>Ajouter un Achat</h2>
    <?php include "formulaire.php"; ?>
   
    <h2>Total du mois en cours: <?php echo $total_mois; ?> €</h2>
    <h2>Liste des Achats</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Date</th>
                <th>Magasin</th>
                <th>Description</th>
                <th>Montant</th>
                <th>Acheteur</th>
                <th>Mode de Paiement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($achats as $achat): ?>
                <tr>
                    <td><?php echo $achat['id']; ?></td>
                    <td><?php echo $achat['date_achat']; ?></td>
                    <td><?php echo $achat['magasin']; ?></td>
                    <td><?php echo $achat['description_achat']; ?></td>
                    <td><?php echo $achat['montant']; ?></td>
                    <td><?php echo $achat['acheteur']; ?></td>
                    <td><?php echo $achat['mode_paiement']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $achat['id']; ?>"><img
                                                                                        src="assets\Crayon-icon.svg"
                                                                                        alt="un crayon"
                                                                                        height="30px"
                                                                                        width="20px" /></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
