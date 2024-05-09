<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require 'vendor/autoload.php';
use Cloudinary\Cloudinary;

$cloudinary = new Cloudinary([
    'cloud' => [
        'cloud_name' => 'do2qwucmp',
        'api_key' => '395927197317534',
        'api_secret' => 'jOH-NgmPdFNNgj0VaQ2ne9kpfO4',
    ]
]);


$generatePath = __DIR__ . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'generate_id.php';
include $generatePath;

if (isset($_POST['send'])) {
    // Vérification de la présence du titre, de la description et des médias
    if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_FILES['media']['name'][0])) {
        // Récupérez les données soumises
        $title = htmlspecialchars($_POST['title']);
        $description = nl2br(htmlspecialchars($_POST['description']));

        $date = date("Y-m-d H:i:s");
        $pubId = generateUniqueId();
        $studentId = $_SESSION['student_id'];

        // Insérez les données de la publication dans la base de données
        $stmt_insert = $conn->prepare('INSERT INTO publications (id, etudiant_id, titre, description, date_publication) VALUES (?, ?, ?, ?, ?)');
        $stmt_insert->bindValue(1, $pubId, PDO::PARAM_STR);
        $stmt_insert->bindValue(2, $studentId, PDO::PARAM_STR);
        $stmt_insert->bindValue(3, $title, PDO::PARAM_STR);
        $stmt_insert->bindValue(4, $description, PDO::PARAM_STR);
        $stmt_insert->bindValue(5, $date, PDO::PARAM_STR);

        if (!$stmt_insert->execute()) {
            $msgError = "Erreur lors de l'ajout de la publication.";
        }

        // Traitement des médias
        foreach ($_FILES['media']['tmp_name'] as $key => $uploadedFile) {
            if ($uploadedFile) {
                $fileType = $_FILES['media']['type'][$key]; // Type MIME du fichier

                if (strpos($fileType, 'image/') === 0) {
                    // Téléchargez l'image sur Cloudinary
                    $uploadResult = $cloudinary->uploadApi()->upload($uploadedFile, [
                        'folder' => $upload_path,
                        'resource_type' => 'image' // Indique que c'est une image
                    ]);

                    if ($uploadResult) {
                        // L'URL de l'image téléchargée
                        $media_url = $uploadResult['secure_url'];

                        // Ajouter les données de l'image dans la table medias
                        $insert_media = $conn->prepare('INSERT INTO medias(id_student, id_publication, media_url, created_at, media_type) VALUES (?, ?, ?, ?, ?)');
                        $insert_media->bindValue(1, $studentId, PDO::PARAM_STR);
                        $insert_media->bindValue(2, $pubId, PDO::PARAM_STR);
                        $insert_media->bindValue(3, $media_url, PDO::PARAM_STR);
                        $insert_media->bindValue(4, $date, PDO::PARAM_STR);
                        $insert_media->bindValue(5, 'image', PDO::PARAM_STR);

                        if (!$insert_media->execute()) {
                            $msgError = "Erreur lors de l'ajout de l'image dans la base de données.";
                        }
                    } else {
                        $msgError = "Erreur lors du téléchargement de l'image.";
                    }
                } elseif (strpos($fileType, 'video/') === 0) {
                    // Téléchargez la vidéo sur Cloudinary
                    $uploadResult = $cloudinary->uploadApi()->upload($uploadedFile, [
                        'folder' => $upload_path,
                        'resource_type' => 'video' // Indique que c'est une vidéo
                    ]);

                    if ($uploadResult) {
                        // L'URL de la vidéo téléchargée
                        $media_url = $uploadResult['secure_url'];

                        // Ajouter les données de la vidéo dans la table medias
                        $insert_media = $conn->prepare('INSERT INTO medias(id_student, id_publication, media_url, created_at, media_type) VALUES (?, ?, ?, ?, ?)');
                        $insert_media->bindValue(1, $studentId, PDO::PARAM_STR);
                        $insert_media->bindValue(2, $pubId, PDO::PARAM_STR);
                        $insert_media->bindValue(3, $media_url, PDO::PARAM_STR);
                        $insert_media->bindValue(4, $date, PDO::PARAM_STR);
                        $insert_media->bindValue(5, 'video', PDO::PARAM_STR);

                        if (!$insert_media->execute()) {
                            $msgError = "Erreur lors de l'ajout de la vidéo dans la base de données.";
                        }
                    } else {
                        $msgError = "Erreur lors du téléchargement de la vidéo.";
                    }
                } else {
                    $msgError = "Type de fichier non pris en charge.";
                }
            }
        }

        if (!isset($msgError)) {
            $successMsg = "Post publié avec succès !";
        }
    } else {
        $msgError = "Complétez tous les champs.";
    }
}