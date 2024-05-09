<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$dbPath = __DIR__ . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'db_connect.php';
include $dbPath;


if (isset($_POST['logout'])) {
    if (isset($_SESSION['student'])) {
        // Mettre à jour la colonne "online" à 0 pour indiquer que le user est hors ligne
        $updateOnlineStatus = $conn->prepare('UPDATE etudiants SET online_statuts = 0 WHERE id = :studentId');
        $updateOnlineStatus->execute(array('studentId' => $_SESSION['student_id']));

        // Détruire la session
        session_destroy();

        header('Location: ./index.php');


    }
}