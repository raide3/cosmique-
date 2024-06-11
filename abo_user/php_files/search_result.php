<?php
session_start();
include('../../entete/connexion_base_données.php');

if (!isset($_SESSION['pseudo'])) {
    header("Location: connexion.php");
    exit();
}


//signe astrologique 


function getAstrologicalSign($birthDate) {
    $date = new DateTime($birthDate);
    $month = $date->format('m');
    $day = $date->format('d');

    if (($month == 1 && $day >= 20) || ($month == 2 && $day <= 18)) {
        return "Verseau";
    } elseif (($month == 2 && $day >= 19) || ($month == 3 && $day <= 20)) {
        return "Poissons";
    } elseif (($month == 3 && $day >= 21) || ($month == 4 && $day <= 19)) {
        return "Bélier";
    } elseif (($month == 4 && $day >= 20) || ($month == 5 && $day <= 20)) {
        return "Taureau";
    } elseif (($month == 5 && $day >= 21) || ($month == 6 && $day <= 20)) {
        return "Gémeaux";
    } elseif (($month == 6 && $day >= 21) || ($month == 7 && $day <= 22)) {
        return "Cancer";
    } elseif (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)) {
        return "Lion";
    } elseif (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)) {
        return "Vierge";
    } elseif (($month == 9 && $day >= 23) || ($month == 10 && $day <= 22)) {
        return "Balance";
    } elseif (($month == 10 && $day >= 23) || ($month == 11 && $day <= 21)) {
        return "Scorpion";
    } elseif (($month == 11 && $day >= 22) || ($month == 12 && $day <= 21)) {
        return "Sagittaire";
    } elseif (($month == 12 && $day >= 22) || ($month == 1 && $day <= 19)) {
        return "Capricorne";
    } else {
        return "Date de naissance invalide";
    }
}

// Exemple d'utilisation
$birthDate = $profil['date_naissance'];
$sign = getAstrologicalSign($birthDate);




// Récupérer les critères de recherche
$age_min = isset($_GET['age_min']) ? intval($_GET['age_min']) : 0;
$age_max = isset($_GET['age_max']) ? intval($_GET['age_max']) : 200;
$description_physique = isset($_GET['description_physique']) ? $conn->real_escape_string($_GET['description_physique']) : '';
$sexe = isset($_GET['sexe']) ? $conn->real_escape_string($_GET['sexe']) : '';


// Construire la requête SQL
$sql = "SELECT pseudo, profession, lieu_residence, situation_familiale, description_physique, informations_personnelles, photo, date_naissance FROM utilisateurs INNER JOIN profils ON utilisateurs.id = profils.utilisateur_id WHERE 1=1";

if ($age_min > 0) {
    $sql .= " AND YEAR(CURDATE()) - YEAR(date_naissance) >= $age_min";
}

if ($age_max > 0) {
    $sql .= " AND YEAR(CURDATE()) - YEAR(date_naissance) <= $age_max";
}

if (!empty($description_physique)) {
    $sql .= " AND description_physique LIKE '%$description_physique%'";
}

if (!empty($sexe)) {
    $sql .= " AND sexe = '$sexe'";
}

$result = $conn->query($sql);

function calculerAge($dateNaissance) {
    // Convertir la date de naissance en objet DateTime
    $dateNaissance = new DateTime($dateNaissance);
    // Obtenir la date actuelle
    $aujourdhui = new DateTime();
    // Calculer la différence en années
    $age = $aujourdhui->diff($dateNaissance)->y;
    return $age;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats de Recherche</title>
    <link rel="stylesheet" href="../css_files/search_result.css">
</head>
<body>
    <h1>Résultats de Recherche</h1>
    <nav>
        <ul>
            <li><a href="main.php">Page Principale</a></li>
            <li><a href="members.php">Voir les membres</a></li>
            <li><a href="profil.php">Mon profil</a></li>
            <li><a href="b_messagerie.php">Messagerie</a></li>
            <li><a href="abonnement.php">S'abonner</a></li>
        </ul>
    </nav>

    <?php
    if ($result->num_rows > 0) {
        while ($profil = $result->fetch_assoc()) {
            echo "<div class='profile-info'>";
            echo "<h2>" . htmlspecialchars($profil['pseudo']) . "</h2>";
            echo "<p><strong>Profession:</strong> " . htmlspecialchars($profil['profession']) . "</p>";
            echo "<p><strong>Lieu de résidence:</strong> " . htmlspecialchars($profil['lieu_residence']) . "</p>";
            echo "<p><strong>Situation familiale:</strong> " . htmlspecialchars($profil['situation_familiale']) . "</p>";
            echo "<p><strong>Description physique:</strong> " . htmlspecialchars($profil['description_physique']) . "</p>";
            echo "<p><strong>Informations personnelles:</strong> " . htmlspecialchars($profil['informations_personnelles']) . "</p>";
            echo "<p><strong>Âge:</strong> " . calculerAge($profil['date_naissance']) . " ans</p>";
            echo "<p><strong>signe astrologique:</strong> " .$sign. " </p>";
            if ($profil['photo']) {
                echo "<p><strong>Photo:</strong> <img src='" . htmlspecialchars($profil['photo']) . "' alt='Photo de " . htmlspecialchars($profil['pseudo']) . "'></p>";
            } else {
                echo "<p><strong>Photo:</strong> <img src='inconnu.png' alt='Photo par défaut'></p>";
            }
            echo "</div>";
        }
    } else {
        echo "Aucun profil trouvé.";
    }
    ?>

</body>
</html>

