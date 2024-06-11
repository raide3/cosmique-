<?php
session_start();
include('../../entete/connexion_base_données.php'); 
$pseudo = $_SESSION['pseud'];
$idi = $_SESSION['idi'];

afficherMessages($conn, $pseudo, $idi);

function afficherMessages($conn, $pseudo, $idi) {
    $sql0 = "SELECT pseudo FROM utilisateurs WHERE id=?";
    $stmt0 = $conn->prepare($sql0);
    $stmt0->bind_param("i", $idi);
    $stmt0->execute();
    $result0 = $stmt0->get_result();
    $destinataire = $result0->fetch_assoc();
    $stmt0->close();

    if (!$destinataire) {
        echo "Utilisateur non trouvé pour le id : $idi";
        exit;
    }

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

    $sql = "SELECT * FROM messages";
    $result = $conn->query($sql);
    $messages = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($messages as $message) {
        if ($message['destinataire_id'] == $user_id && $message['expediteur_id'] == $idi) {
            echo "<p id='him'>De: {$destinataire['pseudo']}<br>Message: {$message['contenu']}<br>Date: {$message['date_envoi']}
            <button class='report-btn' data-message-id='{$message['id']}'>Signaler</button></p>";
        }
        if ($message['expediteur_id'] == $user_id && $message['destinataire_id'] == $idi) {
            echo "<div id='nails'><p id='me'>À: {$destinataire['pseudo']}<br>Message: {$message['contenu']}<br>Date: {$message['date_envoi']}<br></p>
            <button class='delete-btn' data-message-id='{$message['id']}'>Supprimer</button></div>";
        }
    }
}
?>

