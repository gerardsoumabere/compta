<?php


function connectToDatabase()
{

    include('.vscode/db_login.php');


    try {
        $conn = new PDO("mysql:host=$servername;dbname=$db_name", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Code pour créer la table "achats" si elle n'existe pas
        $createTableSQL = "CREATE TABLE IF NOT EXISTS achats (
            id INT AUTO_INCREMENT PRIMARY KEY,
            date_achat DATE NOT NULL,
            magasin VARCHAR(255) NOT NULL,
            description_achat TEXT,
            montant DECIMAL(10, 2) NOT NULL,
            acheteur VARCHAR(50) NOT NULL,
            mode_paiement VARCHAR(50) NOT NULL
        )";

        $conn->exec($createTableSQL);

        // // Code pour créer la table "magasins" si elle n'existe pas
        // $createTableSQL = "CREATE TABLE IF NOT EXISTS magasins (
        //     id INT AUTO_INCREMENT PRIMARY KEY,
        //     nom_magasin VARCHAR(255) NOT NULL
        // )";

        // $conn->exec($createTableSQL);

        // echo '<div class="alert alert-success" role="alert">
        //     Connexion à la base de données réussie .
        // </div>';
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger" role="alert">
            La connexion à la base de données a échoué : ' . $e->getMessage() . '
        </div>';
    }

    return $conn;
}


function ajouterAchat($date, $magasin, $description, $montant, $acheteur, $mode_paiement)
{
    try {
        $conn = connectToDatabase();

        // Utiliser des requêtes préparées avec PDO pour éviter les injections SQL
        $insertSQL = "INSERT INTO achats (date_achat, magasin, description_achat, montant, acheteur, mode_paiement) VALUES (:date_achat, :magasin, :description_achat, :montant, :acheteur, :mode_paiement)";

        $stmt = $conn->prepare($insertSQL);
        $stmt->bindParam(':date_achat', $date, PDO::PARAM_STR);
        $stmt->bindParam(':magasin', $magasin, PDO::PARAM_STR);
        $stmt->bindParam(':description_achat', $description, PDO::PARAM_STR);
        $stmt->bindParam(':montant', $montant, PDO::PARAM_STR);
        $stmt->bindParam(':acheteur', $acheteur, PDO::PARAM_STR);
        $stmt->bindParam(':mode_paiement', $mode_paiement, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">
                    Achat ajouté avec succès à la base de données.
                </div>';
            header('Location: index.php');
        } else {
            echo '<div class="alert alert-danger" role="alert">
                    Erreur lors de l\'ajout de l\'achat : ' . $stmt->errorInfo()[2] . '
                </div>';
        }

        $stmt->closeCursor();
        $conn = null; // Fermeture de la connexion

    } catch (PDOException $e) {
        echo 'Impossible de traiter les données. Erreur : ' . $e->getMessage();
    }
}

function modifierAchat($date, $magasin, $description, $montant, $acheteur, $mode_paiement)
{
    try {
        $conn = connectToDatabase();

        // Utiliser des requêtes préparées avec PDO pour éviter les injections SQL
        $insertSQL = 'UPDATE achats SET date_achat = :date_achat, magasin = :magasin, description_achat = :description_achat, montant = :montant, acheteur = :acheteur, mode_paiement = :mode_paiement WHERE id = :id';

        $stmt = $conn->prepare($insertSQL);
        $stmt->bindParam(':date_achat', $date, PDO::PARAM_STR);
        $stmt->bindParam(':magasin', $magasin, PDO::PARAM_STR);
        $stmt->bindParam(':description_achat', $description, PDO::PARAM_STR);
        $stmt->bindParam(':montant', $montant, PDO::PARAM_STR);
        $stmt->bindParam(':acheteur', $acheteur, PDO::PARAM_STR);
        $stmt->bindParam(':mode_paiement', $mode_paiement, PDO::PARAM_STR);
        $stmt->bindParam(':id', $_GET["id"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">
                    Achat modifié avec succès à la base de données.
                </div>';
            header('Location: index.php');
        } else {
            echo '<div class="alert alert-danger" role="alert">
                    Erreur lors de la modification de l\'achat : ' . $stmt->errorInfo()[2] . '
                </div>';
        }

        $stmt->closeCursor();
        $conn = null; // Fermeture de la connexion

    } catch (PDOException $e) {
        echo 'Impossible de traiter les données. Erreur : ' . $e->getMessage();
    }
}

function isAchatsTableEmpty($conn)
{
    // Requête SQL pour compter le nombre de lignes dans la table "achats"
    $sql = "SELECT COUNT(*) as total FROM achats";

    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $totalRows = $row['total'];

        // Si le total des lignes est égal à zéro, la table est vide
        return $totalRows == 0;
    } else {
        // Gérer les erreurs de requête
        echo "Erreur lors de la vérification de la table 'achats' : " . $conn->error;
        return false;
    }
}

function getAchats()
{
    $conn = connectToDatabase();

    // Utiliser des requêtes préparées avec PDO pour éviter les injections SQL
    $selectSQL = "SELECT * FROM achats ORDER BY date_achat DESC";
    $stmt = $conn->prepare($selectSQL);
    $stmt->execute();

    $achats = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $achats[] = $row;
    }

    $stmt->closeCursor();
    $conn = null; // Fermeture de la connexion

    return $achats;
}

function getAchat()
{

    if (isset($_GET["id"])) {


        $id = $_GET["id"];

        $conn = connectToDatabase();

        // Utiliser des requêtes préparées avec PDO pour éviter les injections SQL
        $selectSQL = "SELECT date_achat,magasin,description_achat,montant,acheteur,mode_paiement FROM achats WHERE id=('$id') ";
        $stmt = $conn->prepare($selectSQL);
        $stmt->execute();

        $achat = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $achat[] = $row;
        }

        $stmt->closeCursor();
        $conn = null; // Fermeture de la connexion

        return $achat;
    }
}

function totalMois()
{
    try {
        $conn = connectToDatabase();
        $selectSQL = 'SELECT SUM(montant) AS total FROM achats WHERE date_achat BETWEEN DATE(CONCAT(YEAR(NOW()), "-", MONTH(NOW()), "-10")) AND DATE_ADD(DATE(CONCAT(YEAR(NOW()), "-", MONTH(NOW()), "-10")), INTERVAL 1 MONTH)';
        $stmt = $conn->prepare($selectSQL);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $total = $result['total'];

        $stmt->closeCursor();
        $conn = null; // Fermeture de la connexion

        return $total;
    } catch (PDOException $e) {
        echo 'Impossible de traiter les données. Erreur : ' . $e->getMessage();
    }
}

// <?php
//         require 'fonctions.php'; // Inclure le fichier contenant les fonctions



//         // Gérer l'ajout d'achat depuis le formulaire
//         if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajouter_achat"])) {
//             $date = $_POST["date"];
//             $lieu = $_POST["lieu"];
//             $description = $_POST["description"];
//             $montant = $_POST["montant"];
//             $acheteur = $_POST["acheteur"];
//             $mode_paiement = $_POST["mode_paiement"];

//             // Ajouter l'achat en base de données
//             ajouterAchat($date, $lieu, $description, $montant, $acheteur, $mode_paiement);
//         }

//         // Gérer la pagination

//         $achatsParPage = 10;
//         $page = isset($_GET['page']) ? $_GET['page'] : 1;
//         $offset = ($page - 1) * $achatsParPage;

//         // Récupérer la liste des achats pour l'affichage
//         $achats = getAchatsPagination($achatsParPage, $offset);


//     ?>