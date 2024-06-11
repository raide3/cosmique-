<?php

include('../../entete/connexion_base_données.php');
session_start();
if (!isset($_SESSION['pseudo']) || $_SESSION['code'] !== 'administrateur') {
   header("Location: connexion.php");
   exit();
}



$sql = "SELECT s.id, s.message_id, s.reason, s.created_at, s.user_id, u.pseudo as reporter, m.contenu as message
        FROM signalements s
        JOIN utilisateurs u ON s.reporter_id = u.id
        JOIN messages m ON s.message_id = m.id";
$result = $conn->query($sql);
$signalements = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modération des signalements</title>
    <link rel="stylesheet" href="../css_files/moderation.css">
</head>
<body>
        <nav>
        <ul>
            <li><a href="members.php">Gérer les utilisateurs</a></li>
            <li><a href="gerer_abonnements.php">Gérer les profils</a></li>
            <li><a href="moderation.php">Gérer les messages</a></li>
            <li><a href="main_admin.php">main</a></li>
        </ul>
    </nav>
    <h1>Modération des signalements</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Message</th>
                <th>Motif</th>
                <th>Date</th>
                <th>Reporté par</th>
                <th>le/la nuisible</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($signalements as $signalement): ?>
            <tr>
                <td><?php echo $signalement['id']; ?></td>
                <td><?php echo $signalement['message_id']; ?></td>
                <td><?php echo $signalement['reason']; ?></td>
                <td><?php echo $signalement['created_at']; ?></td>
                <td><?php echo $signalement['reporter']; ?></td>
                <td><?php echo $signalement['user_id']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    
</body>
</html>

<?php

// Fonction pour supprimer un message
function supprimerMessage($conn, $message_id) {
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->bind_param("i", $message_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return true;
    } else {
        return false;
    }
}

// Fonction pour supprimer un utilisateur
function supprimerUtilisateur($conn, $user_id) {
    $stmt = $conn->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return true;
    } else {
        return false;
    }
}

// Traitement du formulaire pour supprimer un message
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['supprimer_message'])) {
    $message_id = $_POST['message_id'];
    if (supprimerMessage($conn, $message_id)) {
        echo "Le message a été supprimé avec succès.";
    } else {
        echo "Une erreur s'est produite lors de la suppression du message.";
    }
}

// Traitement du formulaire pour supprimer un utilisateur
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['supprimer_utilisateur'])) {
    $user_id = $_POST['user_id'];
    if (supprimerUtilisateur($conn, $user_id)) {
        echo "L'utilisateur a été supprimé avec succès.";
    } else {
        echo $conn->error."Une erreur s'est produite lors de la suppression de l'utilisateur.";
    }
    
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression de messages et d'utilisateurs</title>
</head>
<body>

<h2>Supprimer un message</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="message_id">ID du message à supprimer :</label>
    <input type="text" id="message_id" name="message_id">
    <button type="submit" name="supprimer_message">Supprimer le message</button>
</form>

<h2>Supprimer un utilisateur</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="user_id">ID de l'utilisateur à supprimer :</label>
    <input type="text" id="user_id" name="user_id">
    <button type="submit" name="supprimer_utilisateur">Supprimer l'utilisateur</button>
</form>

</body>
</html>

<?php
// Fermer la connexion à la base de données à la fin du script
$conn->close();
?>

