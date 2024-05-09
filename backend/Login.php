<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure les fichiers de connexion à la base de données et la fonction de génération d'ID
$dbPath = __DIR__ . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'db_connect.php';
$generatePath = __DIR__ . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'generate_id.php';

// Inclure les fichiers
include $dbPath;
include $generatePath;

if (isset($_POST['login'])) {

    if (!empty($_POST['email']) and !empty($_POST['mdp'])) {
        $email = htmlspecialchars($_POST['email']);
        $mdp = htmlspecialchars($_POST['mdp']);

        // Préparer la requête pour vérifier les identifiants de l'utilisateur
        $stmt = $conn->prepare('SELECT id, fname, email, mot_de_passe,online_statuts, profil FROM etudiants WHERE email = ?');
        $stmt->execute([$email]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($student && password_verify($mdp, $student['mot_de_passe'])) {
            // Vérifier si l'utilisateur est déjà en ligne
            if ($student['online_statuts'] == 1) {
                $msgErrors = "Vous êtes déjà connecté.";
            } else {
                // Stocker les informations de l'utilisateur dans la session
                $_SESSION['student'] = true;
                $_SESSION['student_id'] = $student['id'];
                $_SESSION['student_name'] = $student['fname'];
                $_SESSION['student_profil'] = $student['profil'];
                $_SESSION['student_email'] = $student['email'];

                // Mettre à jour la colonne 'online' à 1 pour cet utilisateur
                $stmt_update = $conn->prepare('UPDATE etudiants SET online_statuts = 1 WHERE id = ?');
                $stmt_update->execute([$student['id']]);

                header('Location: index.php');


            }
        } else {
            $msgError = "Email ou mot de passe incorrect.";
        }
    } else {
        $msgError = "Completez tous les champs...";
    }
}