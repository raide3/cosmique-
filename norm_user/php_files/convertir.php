<?php
// Connexion à la base de données SQLite
$db = new SQLite3('utilisateurs.db');

// Création de la table utilisateurs
$db->exec('CREATE TABLE IF NOT EXISTS utilisateurs (
    id INTEGER PRIMARY KEY,
    nom TEXT,
    prenom TEXT,
    email TEXT
)');

// Lecture du fichier texte et insertion des données dans la base de données
$file = fopen('utilisateurs.txt', 'r');
if ($file) {
    // Sauter l'entête
    fgets($file);
    while (($line = fgets($file)) !== false) {
        list($id, $nom, $prenom, $email) = explode(',', trim($line));
        $stmt = $db->prepare('INSERT INTO utilisateurs (id, nom, prenom, email) VALUES (?, ?, ?, ?)');
        $stmt->bindValue(1, $id, SQLITE3_INTEGER);
        $stmt->bindValue(2, $nom, SQLITE3_TEXT);
        $stmt->bindValue(3, $prenom, SQLITE3_TEXT);
        $stmt->bindValue(4, $email, SQLITE3_TEXT);
        $stmt->execute();
    }
    fclose($file);
}

echo "Conversion terminée!";
?>

