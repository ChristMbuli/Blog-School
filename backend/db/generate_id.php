<?php
// Fonction pour générer un identifiant unique de 24 caractères hexadécimaux
function generateUniqueId()
{
    // Générer 12 octets de données aléatoires
    $randomBytes = random_bytes(12);

    // Convertir les octets en chaîne hexadécimale
    $uniqueId = bin2hex($randomBytes);

    // Retourner l'identifiant unique de 24 caractères hexadécimaux
    return $uniqueId;
}