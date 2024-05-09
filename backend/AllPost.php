<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure le fichier de connexion à la base de données
$route_db = __DIR__ . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'db_connect.php';
include $route_db;

// Préparez la requête SQL pour récupérer les posts avec leur première image
$query = $conn->prepare('SELECT p.id, p.description, p.etudiant_id ,p.date_publication, m.id_publication, m.media_url, m.media_type, e.id as student_id, e.fname, e.profil
    FROM publications p
    JOIN etudiants e ON p.etudiant_id = e.id
    JOIN medias m ON p.id = m.id_publication
    GROUP BY p.id
    ORDER BY p.date_publication DESC
');

// Exécutez la requête
$query->execute();