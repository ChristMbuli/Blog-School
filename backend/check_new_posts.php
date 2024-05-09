<?php
// Inclure la connexion à la base de données
include 'db_connect.php';

// Récupérer l'heure de la dernière vérification depuis la requête (par exemple, transmise par un paramètre GET ou POST)
$lastCheckedTime = isset($_GET['last_checked_time']) ? $_GET['last_checked_time'] : '1970-01-01 00:00:00';

// Préparer la requête SQL pour récupérer les nouvelles publications
$query = $conn->prepare('SELECT p.id, p.description, p.date_publication, m.media_url, m.media_type, e.fname, e.profil
                         FROM publications p
                         JOIN etudiants e ON p.etudiant_id = e.id
                         JOIN medias m ON p.id = m.id_publication
                         WHERE p.date_publication > :lastCheckedTime
                         GROUP BY p.id
                         ORDER BY p.date_publication DESC');
$query->bindValue(':lastCheckedTime', $lastCheckedTime);
$query->execute();

// Récupérer les résultats
$newPosts = $query->fetchAll(PDO::FETCH_ASSOC);

// Retourner les nouvelles publications au format JSON
echo json_encode(['newPosts' => $newPosts]);

// Fermer la connexion à la base de données
$conn = null;