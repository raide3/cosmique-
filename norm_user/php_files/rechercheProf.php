<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche d'utilisateurs</title>
    <style>
        body {
            background-image: url('../images/cosmos.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            color: #fff;
            text-align: center;
            padding: 50px;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        form {
            background: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-size: 1.2em;
        }
        input[type="text"] {
            width: 80%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            font-size: 1em;
            cursor: pointer;
        }
        .profile-summary {
            background: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: left;
            display: inline-block;
            width: 80%;
            max-width: 600px;
        }
        .profile-summary p {
            margin: 5px 0;
            font-size: 1.1em;
        }
        .profile-summary img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            font-size: 1em;
            cursor: pointer;
            display: inline-block;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .no-results {
            background: rgba(255, 0, 0, 0.7);
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>Recherche d'utilisateurs</h1>
    <form method="post" action="rechercheProf.php">
        <label for="pseudo">Pseudo:</label>
        <input type="text" id="pseudo" name="pseudo" required>
        <input type="submit" value="Rechercher">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pseudo_recherche = trim($_POST['pseudo']);
        $users = file('utilisateurs.txt', FILE_IGNORE_NEW_LINES);

        echo "<h2>Résultats de la recherche:</h2>";
        $found = false;
        foreach ($users as $userData) {
            $userData = trim($userData); // Remove any whitespace around the data
            list($nom, $prenom, $email, $pseudo, $mdp, $gender, $taille, $poids, $fonction, $date_naissance, $signe_astrologique, $situation_amoureuse, $photo_profil) = explode(',', $userData);
            if (stripos($pseudo, $pseudo_recherche) !== false) {
                $found = true;
                ?>
                <div class="profile-summary">
                    <img src="<?= htmlspecialchars($photo_profil) ?>" alt="Photo de profil">
                    <p><strong>Nom:</strong> <?= htmlspecialchars($nom) ?></p>
                    <p><strong>Prénom:</strong> <?= htmlspecialchars($prenom) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
                    <p><strong>Pseudo:</strong> <?= htmlspecialchars($pseudo) ?></p>
                    <p><strong>Sexe:</strong> <?= htmlspecialchars($gender) ?></p>
                    <p><strong>Taille:</strong> <?= htmlspecialchars($taille) ?></p>
                    <p><strong>Poids:</strong> <?= htmlspecialchars($poids) ?></p>
                    <p><strong>Fonction:</strong> <?= htmlspecialchars($fonction) ?></p>
                    <p><strong>Date de Naissance:</strong> <?= htmlspecialchars($date_naissance) ?></p>
                    <p><strong>Signe Astrologique:</strong> <?= htmlspecialchars($signe_astrologique) ?></p>
                    <p><strong>Situation Amoureuse:</strong> <?= htmlspecialchars($situation_amoureuse) ?></p>
                    <button class="btn" onclick="sendFriendRequest('<?= htmlspecialchars($pseudo) ?>')">Envoyer une demande d'amitié</button>
                </div>
                <?php
            }
        }
        if (!$found) {
            echo "<p class='no-results'>Aucun utilisateur trouvé avec ce pseudo.</p>";
        }
    }
    ?>

    <script>
        function sendFriendRequest(pseudo) {
            alert("Demande d'amitié envoyée à " + pseudo);
        }
    </script>
</body>
</html>

