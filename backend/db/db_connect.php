<?php
try {
    // Créer une nouvelle instance de PDO avec les paramètres de connexion
    $conn = new PDO('mysql:host=localhost;dbname=media_social;charset=utf8;', 'root', '');

    // Configurer PDO pour lancer des exceptions en cas d'erreurs
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Connexion réussie
    // echo "Connexion réussie à la base de données.";

} catch (PDOException $e) {
    // Afficher l'erreur de connexion
    die('Erreur de connexion : ' . $e->getMessage());
}