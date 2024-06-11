<?php
session_start();
if (!isset($_SESSION['pseudo'])) {
    header("Location: connexion.php");
    exit();
}
include('../../entete/connexion_base_données.php'); 
$pseudo = $_SESSION['pseudo'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page Principale</title>
    <link rel="stylesheet" href="../css_files/main.css">
</head>
<body>
    <h1>Bienvenue, <?php echo htmlspecialchars($pseudo); ?></h1>
    <nav>
        <ul>
            <li><a href="members.php">Voir les membres</a></li>
            <li><a href="b_messagerie.php">Messagerie</a></li>
            <li><a href="profil.php">Mon Profil</a></li>
            <li><a href="choix_abo.php">S'abonner</a></li>
        </ul>
    </nav>
    <form action="search_result.php" method="get">
        <label for="age_min">Âge minimum:</label>
        <input type="number" id="age_min" name="age_min">

        <label for="age_max">Âge maximum:</label>
        <input type="number" id="age_max" name="age_max">
        
        <label for="sexe">Sexe:</label>
        <select id="sexe" name="sexe">
            <option value="">Tous</option>
            <option value="Homme">Homme</option>
            <option value="Femme">Femme</option>
            <option value="Autre">Autre</option>
        </select>

        <label for="description_physique">Description physique:</label>
        <input type="text" id="description_physique" name="description_physique">
	
        <button type="submit">Rechercher</button>
    </form>


</body>
</html>

