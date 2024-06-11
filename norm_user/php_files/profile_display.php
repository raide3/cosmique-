<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Affichage du profil</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .profile { border: 1px solid #ccc; padding: 10px; margin: 10px 0; }
        .profile-header { background-color: #f4f4f4; padding: 10px; }
        .profile-body { padding: 10px; }
    </style>
</head>
<body>
    <?php
    if (isset($_GET['user'])) {
        $user = $_GET['user'];
        $users = file('utilisateurs.txt', FILE_IGNORE_NEW_LINES);
        $found = false;
        foreach ($users as $userData) {
            $data = explode(',', $userData);
            if ($data[3] == $user) { // Pseudo est à la 4ème position
                $found = true;
                echo "<div class='profile'>
                    <div class='profile-header'>
                        <strong>" . htmlspecialchars($data[3]) . "</strong>
                    </div>
                    <div class='profile-body'>
                        <p><strong>Nom:</strong> " . htmlspecialchars($data[0]) . "</p>
                        <p><strong>Prénom:</strong>

