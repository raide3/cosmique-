<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur votre site</title>
    <style>
        .navbar {
            background-color: #333;
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        body {
            background-image: url('../images/cosmos.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 7px auto 100px;
            text-align: center;
        }

        .welcome-message {
            font-size: 24px;
            color: #333;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile {
            background-color: #fff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            text-align: left;
        }

        .profile-header {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .profile-body p {
            margin: 5px 0;
        }

        .profile-footer {
            margin-top: 10px;
            text-align: center;
        }

        .profile-footer .btn {
            margin: 5px;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .profile-footer .btn:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function loadProfiles() {
            fetch('get_profiles.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('profiles').innerHTML = data;
                })
                .catch(error => console.error('Erreur:', error));
        }

        function sendFriendRequest(pseudo) {
            alert('Demande d\'amitié envoyée à ' + pseudo);
        }

        function sendMessage(pseudo) {
            alert('Message envoyé à ' + pseudo);
        }
    </script>
</head>
<body>
    <div class="navbar">
        <a href="notification.php"><i class="fas fa-home"></i> Notification</a>
        <a href="../html_files/messaging.html"><i class="fas fa-search"></i> Groupe Chat</a>
        <a href="choix_abo.php"><i class="fas fa-user"></i> Offres abonnements</a>
        <a href="DS.php"><i class="fas fa-user"></i> Demandes de Suivi</a>
        <a href="../html_files/profile_display.html"><i class="fas fa-user"></i> Compte</a>
        <a href="Profile.php"><i class="fas fa-user"></i> Profil</a>
        <a href="rechercheProf.php"><i class="fas fa-user"></i> Recherche des autres Profiles</a>
    </div>
    <div class="container">
        <?php
        session_start();
        if(isset($_SESSION['username'])) {
            echo "<div class='welcome-message'>Bienvenue " . $_SESSION['username'] . "!</div>";
        } else {
            echo "<div class='welcome-message'>Bienvenue !</div>";
        }
        ?>
        <button onclick="loadProfiles()">Afficher les profils</button>
        <div id="profiles"></div>
    </div>
</body>
</html>

