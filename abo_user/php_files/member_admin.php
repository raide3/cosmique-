<?php
session_start();
if (!isset($_SESSION['pseudo'])) {
    header("Location: connexion.php");
    exit();
}
include('../../entete/connexion_base_données.php');

// Récupérer les informations des membres
$sql = "SELECT utilisateur_id,pseudo, photo, description_physique FROM utilisateurs INNER JOIN profils ON utilisateurs.id = profils.utilisateur_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Membres</title>
    <link rel="stylesheet" href="../css_files/members.css">
</head>
<body>
    <h1>Voir les membres</h1>
        <nav>
        <ul>
            <li><a href="member_admin.php">Gérer les profils</a></li>
            <li><a href="moderation.php">Gérer les messages</a></li>
            <li><a href="main.php">simulation membre premium</a></li>
        </ul>
    </nav>

    <div class="members-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='member'>";
                
                echo "<a href='profil_admin.php?id=" . htmlspecialchars($row['utilisateur_id']) . "'>";
                if ($row['photo']) {
                    echo "<img src='../images/" . htmlspecialchars($row['photo']) . "' alt='Photo de " . htmlspecialchars($row['pseudo']) . "'>";
                } else {
                    echo "<img src='inconnu.png' alt='Photo par défaut'>";
                }echo "<h2>" . htmlspecialchars($row['pseudo']) . "</h2>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucun membre trouvé.</p>";
        }
        ?>
    </div>
</body>
</html>


