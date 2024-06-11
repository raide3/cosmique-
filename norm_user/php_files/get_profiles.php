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
        .btn { margin: 5px; padding: 10px; background-color: #007bff; color: white; border: none; cursor: pointer; }
        .btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <?php
    $users = file('utilisateurs.txt', FILE_IGNORE_NEW_LINES);
    $output = "";

    foreach ($users as $user) {
        list($nom, $prenom, $email, $pseudo, $mdp, $sexe, $taille, $poids, $date_naissance, $signe, $situation_famille) = explode(',', $user);
        $output .= "<div class='profile'>
            <div class='profile-header'>
                <strong>" . htmlspecialchars($pseudo) . "</strong>
            </div>
            <div class='profile-body'>
                <p><strong>Nom:</strong> " . htmlspecialchars($nom) . "</p>
                <p><strong>Prénom:</strong> " . htmlspecialchars($prenom) . "</p>
                <p><strong>Signe astrologique:</strong> " . htmlspecialchars($signe) . "</p>
            </div>
            <div class='profile-footer'>
                <button class='btn' onclick='sendFriendRequest(\"" . htmlspecialchars($pseudo) . "\")'>Envoyer une demande d'amitié</button>
            </div>
        </div>";
    }

    echo $output;
    ?>
    <script>
        function sendFriendRequest(pseudo) {
            alert("Demande d'amitié envoyée à " + pseudo);
        }
    </script>
</body>
</html>

