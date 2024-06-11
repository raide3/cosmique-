<?php
session_start();
include('../../entete/connexion_base_données.php');

if (!isset($_POST['message_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID de message non fourni']);
    exit();
}

$message_id = $_POST['message_id'];
$stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
$stmt->bind_param("i", $message_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Message supprimé']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>


