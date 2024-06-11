<?php
session_start();
include('../../entete/connexion_base_données.php');

if (!isset($_SESSION['pseudo'])) {
    header("Location: connexion.php");
    exit();
}

$userId = $_GET['id'] ?? null;
$_SESSION['userId'] = $userId;

if ($userId) {
    $sql2 = "SELECT pseudo, profession, lieu_residence, situation_familiale, description_physique, informations_personnelles, photo 
             FROM utilisateurs 
             INNER JOIN profils ON utilisateurs.id = profils.utilisateur_id 
             WHERE utilisateurs.id = $userId";
    $result2 = $conn->query($sql2);

    if ($result2->num_rows > 0) {
        $profil = $result2->fetch_assoc();
    } else {
        echo "Profil non trouvé.";
        exit();
    }
} else {
    echo "Aucun ID de membre spécifié.";
    exit();
}

$pseudo = $_SESSION['pseudo'];
$sql0 = "SELECT id FROM utilisateurs WHERE pseudo='$pseudo'";
$result0 = $conn->query($sql0);
$bloqueur = $result0->fetch_assoc()['id'];

$isBlocked = false;
$blockCheckSql = "SELECT * FROM blocages WHERE bloqueur_id = $bloqueur AND bloque_id = $userId";
$blockCheckResult = $conn->query($blockCheckSql);

if ($blockCheckResult->num_rows > 0) {
    $isBlocked = true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bloquer_id'])) {
    $bloquer_id = $userId;
    $sql = "SELECT * FROM blocages WHERE bloqueur_id = $bloqueur AND bloque_id = $bloquer_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $sql = "INSERT INTO blocages (bloqueur_id, bloque_id) VALUES ($bloqueur, $bloquer_id)";
        $conn->query($sql);
    }

    header("Location: main.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil de <?php echo htmlspecialchars($profil['pseudo']); ?></title>
    <link rel="stylesheet" href="../css_files/profile_details.css">
</head>
<body>
    <h1>Profil de <?php echo htmlspecialchars($profil['pseudo']); ?></h1>
    <nav>
        <ul>
            <li><a href="main.php">Page Principale</a></li>
            <li><a href="members.php">Voir les membres</a></li>
            <li><a href="profil.php">Mon profil</a></li>
            <li><a href="b_messagerie.php">Messagerie</a></li>
            <li><a href="abonnement.php">S'abonner</a></li>
        </ul>
    </nav>



    <?php if (!$isBlocked) { ?>
        <div class="profile-info">
        <h2>Informations du Profil</h2>
        <p><strong>Pseudo:</strong> <?php echo htmlspecialchars($profil['pseudo']); ?></p>
        <p><strong>Profession:</strong> <?php echo htmlspecialchars($profil['profession']); ?></p>
        <p><strong>Lieu de résidence:</strong> <?php echo htmlspecialchars($profil['lieu_residence']); ?></p>
        <p><strong>Situation familiale:</strong> <?php echo htmlspecialchars($profil['situation_familiale']); ?></p>
        <p><strong>Description physique:</strong> <?php echo htmlspecialchars($profil['description_physique']); ?></p>
        <p><strong>Informations personnelles:</strong> <?php echo htmlspecialchars($profil['informations_personnelles']); ?></p>
        <?php if ($profil['photo']) { ?>
            <p><strong>Photo:</strong> <img src="<?php echo htmlspecialchars($profil['photo']); ?>" alt="Photo de <?php echo htmlspecialchars($profil['pseudo']); ?>"></p>
        <?php } else { ?>
            <p><strong>Photo:</strong> <img src="inconnu.png" alt="Photo par défaut"></p>
        <?php } ?>
        <a href="messagerie.php?identifiant=<?php echo $_SESSION['userId']; ?>">Envoyer un message</a>
    </div>
        <form action="profile_details.php?id=<?php echo $userId; ?>" method="post">
            <button type="submit" name="bloquer_id">Bloquer</button>
        </form>
    <?php } else { $sql3 = "DELETE FROM messages 
        WHERE (expediteur_id = $userId AND destinataire_id = $bloqueur) 
        OR (expediteur_id = $bloqueur AND destinataire_id = $userId)";if ($conn->query($sql3) === TRUE) {
            echo "plus de messages ";
        } else {
            echo "Erreur lors de la suppression du message : " . $conn->error;
        }?>

    
        <p>Vous avez bloqué cet utilisateur.</p>
    <?php } ?>
</body>
</html>

