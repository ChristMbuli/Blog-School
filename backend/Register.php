<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dbPath = __DIR__ . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'db_connect.php';
$generatePath = __DIR__ . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'generate_id.php';

include $dbPath;
include $generatePath;

// Vérifiez si le formulaire a été soumis
if (isset($_POST['register'])) {
    // Vérifiez que tous les champs obligatoires sont remplis
    if (!empty($_POST['fname']) && !empty($_POST['email']) && !empty($_POST['mdp1']) && !empty($_POST['mdp2'])) {
        // Stockez les données saisies dans des variables, tout en utilisant htmlspecialchars pour prévenir les attaques XSS
        $name = htmlspecialchars($_POST['fname']);
        $email = htmlspecialchars($_POST['email']);
        $mdp1 = htmlspecialchars($_POST['mdp1']);
        $mdp2 = htmlspecialchars($_POST['mdp2']);

        $userId = generateUniqueId();


        // Vérifiez que les deux mots de passe saisis correspondent
        if ($mdp1 === $mdp2) {
            // Hachez le mot de passe
            $hashed_password = password_hash($mdp1, PASSWORD_DEFAULT);
        } else {
            $msgError = "Les mots de passe ne correspondent pas.";
        }

        // Date actuelle
        $date = date("Y-m-d H:i:s");

        // Statut de connexion initial (hors ligne)
        $online = 0;

        // Vérifiez si l'étudiant existe déjà dans la base de données
        $stmt_check = $conn->prepare('SELECT COUNT(*) FROM etudiants WHERE fname = ? AND email = ?');
        $stmt_check->execute([$name, $email]);
        $count = $stmt_check->fetchColumn();

        if ($count > 0) {
            $msgError = "Les informations existent déjà dans la base de données.";
        } else {
            // Préparez et exécutez la requête SQL pour insérer les données dans la base de données
            $stmt_insert = $conn->prepare('INSERT INTO etudiants (id, fname, email, mot_de_passe, online_statuts, created_at) VALUES (?, ?, ?, ?, ?,?)');
            $stmt_insert->bindValue(1, $userId, PDO::PARAM_STR);
            $stmt_insert->bindValue(2, $name, PDO::PARAM_STR);
            $stmt_insert->bindValue(3, $email, PDO::PARAM_STR);
            $stmt_insert->bindValue(4, $hashed_password, PDO::PARAM_STR);
            $stmt_insert->bindValue(5, $online, PDO::PARAM_INT);
            $stmt_insert->bindValue(6, $date, PDO::PARAM_STR);

            // Exécutez la requête préparée
            if ($stmt_insert->execute()) {
                // Redirigez vers la page de connexion après l'inscription réussie
                header('Location: signin.php');
                exit; // Assurez-vous de sortir après la redirection
            } else {
                $msgError = "Une erreur s'est produite lors de l'enregistrement des informations.";
            }

            // Fermez la requête préparée
            $stmt_insert->closeCursor();
        }
    } else {
        $msgError = "Veuillez compléter tous les champs.";
    }
}