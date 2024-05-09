<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure le fichier de connexion à la base de données
$route_db = __DIR__ . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'db_connect.php';
include $route_db;

$cardsHtml = "";



// Vérifier si un identifiant de produit a été passé dans l'URL
if (isset($_GET['id'])) {
    // Valider l'identifiant pour s'assurer qu'il s'agit d'une chaîne de caractères
    $postId = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');


    // Préparer la requête SQL pour vérifier si le post existe et obtenir ses détails
    $stmt = $conn->prepare('SELECT p.id, p.titre, p.description, p.etudiant_id, p.date_publication,
                                e.id as id_student, e.fname, e.profil
                            FROM publications p
                            JOIN etudiants e ON p.etudiant_id = e.id
                            WHERE p.id = ?');
    $stmt->bindValue(1, $postId, PDO::PARAM_STR);

    // Exécuter la requête
    $stmt->execute();

    // Vérifier s'il y a un résultat
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        // Extraire les détails du posts
        $title = htmlspecialchars($row['titre']);
        $description = htmlspecialchars($row['description']);
        $date = htmlspecialchars($row['date_publication']);


        // Extraire les informations etudiants
        $studentName = htmlspecialchars($row['fname']);
        $studentName = htmlspecialchars($row['fname']);

        // Vérifier si 'profil' est null avant de passer à htmlspecialchars()
        if ($row['profil'] !== null) {
            $studentProfile = htmlspecialchars($row['profil']);
        } else {
            // Gérer la valeur null de 'profil'
            // Par exemple, utiliser une chaîne vide ou une autre valeur par défaut
            $studentProfile = 'null';
        }

        // Fermer la requête
        $stmt->closeCursor();

        // Préparer une requête pour récupérer toutes les images associées à l'article
        $imagesStmt = $conn->prepare('SELECT m.media_url, m.media_type FROM medias m
                                    JOIN publications p ON m.id_publication = p.id WHERE p.id = ?');
        $imagesStmt->bindValue(1, $postId, PDO::PARAM_STR);
        $imagesStmt->execute();

        // Récupérer les images dans un tableau
        $images = [];
        while ($imageRow = $imagesStmt->fetch(PDO::FETCH_ASSOC)) {
            $images[] = htmlspecialchars($imageRow['media_url']);
        }
        $imagesStmt->closeCursor();

    } else {
        // Afficher un message si le produit n'est pas trouvé
        $msgError = "Le produit demandé n'a pas été trouvé.";
    }
} else {
    // Afficher un message si aucun identifiant de produit n'est passé
    $msgError = "Aucun identifiant de produit spécifié.";
}