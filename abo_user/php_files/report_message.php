<?php
session_start();
include('../../entete/connexion_base_données.php');

$pseudo = $_SESSION['pseudo'];

    $sql1 = "SELECT id FROM utilisateurs WHERE pseudo=?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("s", $pseudo);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $user = $result1->fetch_assoc();
    $stmt1->close();

    if (!$user) {
        echo "Utilisateur non trouvé pour le pseudo : $pseudo";
        exit;
    }
    $user_id = $user['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message_id = $_POST['message_id'];
    $reporter_id = $user['id'];
    $reason = $_POST['reason'];

    // Enregistrer le signalement dans la base de données
    $stmt = $conn->prepare("INSERT INTO signalements (message_id, user_id, reporter_id, reason) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $message_id, $_SESSION['idi'], $reporter_id, $reason);
    $stmt->execute();

    // Vérifier le nombre de signalements pour cet utilisateur
    $stmt = $conn->prepare("SELECT COUNT(*) as report_count FROM signalements WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['report_count'] >= 3) {
    // Supprimer l'utilisateur de la base de données
    $stmt = $conn->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['idi']);
    $stmt->execute();
    }

    $stmt->close();
    $conn->close();

    // Rediriger vers la page de messagerie avec un message de confirmation
    echo "a";
	 header("Location: messagerie.php?identifiant=" . urlencode($_SESSION['idi']));
    exit();
}
?>

