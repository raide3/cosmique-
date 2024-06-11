<?php
session_start();
$data = json_decode(file_get_contents('php://input'), true);
$from = $_SESSION['username'];
$to = $data['to'];

$notification = "$from vous a envoyé une demande d'amitié.\n";

$notificationFile = "notifications_$to.txt";
file_put_contents($notificationFile, $notification, FILE_APPEND);

echo "Demande d'amitié envoyée à $to";
?>

