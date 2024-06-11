<?php
session_start();
if (!isset($_SESSION['pseudo'])) {
    header("Location: connexion.php");
    exit();
}

include('../../entete/connexion_base_données.php'); 
$pseudo = $_SESSION['pseudo'];

// Récupérer l'ID de l'utilisateur connecté de manière plus concise
$user_id = $conn->query("SELECT id FROM utilisateurs WHERE pseudo='$pseudo'")->fetch_assoc()['id'];

// Récupérer les utilisateurs avec lesquels il y a des conversations
$sql = "SELECT DISTINCT IF(expediteur_id = $user_id, destinataire_id, expediteur_id) AS interlocuteur_id FROM messages WHERE expediteur_id = $user_id OR destinataire_id = $user_id";
$result = $conn->query($sql);
$interlocuteurs = $result->fetch_all(MYSQLI_ASSOC);

// Récupérer les pseudos des interlocuteurs
$interlocuteurs_data = [];
foreach ($interlocuteurs as $interlocuteur) {
    $interlocuteur_id = $interlocuteur['interlocuteur_id'];
    $sql = "SELECT pseudo FROM utilisateurs WHERE id = $interlocuteur_id";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();
    $interlocuteurs_data[] = [
        'id' => $interlocuteur_id,
        'pseudo' => $user_data['pseudo']
    ];
}



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Boîte de messagerie</title>  
    <link rel="stylesheet" href="../css_files/b_messagerie.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="main.php">Page Principale</a></li>
            <li><a href="members.php">Voir les membres</a></li>
            <li><a href="messagerie.php">Messagerie</a></li>
            <li><a href="abonnement.php">S'abonner</a></li>
        </ul>
    </nav>
    
    <h1>Boîte de messagerie</h1>
    <div class="container">
        <h2>Conversations</h2>
            <?php foreach ($interlocuteurs_data as $interlocuteur): ?>
                    <a href="messagerie.php?identifiant=<?php echo $interlocuteur['id']; ?>">
                        <?php echo htmlspecialchars($interlocuteur['pseudo']); ?><br>
                    </a> 
                    <?php $a=$interlocuteur['id'];
$sql1 = "SELECT * FROM messages 
        WHERE (expediteur_id = $user_id AND destinataire_id = $a) 
        OR (expediteur_id = $a AND destinataire_id = $user_id)
        ORDER BY date_envoi DESC 
        LIMIT 1";

$result1 = $conn->query($sql1);
if (!$result1) {
    echo "Erreur de requête : " . $conn->error;
    exit;
}

$dernier_message = $result1->fetch_assoc();
                    if ($dernier_message) {

    echo "De: " . ($dernier_message['expediteur_id'] == $user_id ? "Vous" : $interlocuteur['pseudo']) . "<br>";
    echo "Message: " . $dernier_message['contenu'] . "<br>";
    echo "Date: " . $dernier_message['date_envoi'] . "<br>";} ?>

            <?php endforeach; ?>
    </div>
</body>
</html>

