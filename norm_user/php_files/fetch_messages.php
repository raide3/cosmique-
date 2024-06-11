<?php
session_start();

$users = file('utilisateurs.txt', FILE_IGNORE_NEW_LINES);
$user_lookup = [];
foreach ($users as $user) {
    list($nom, $prenom, $email, $pseudo, $mdp) = explode(',', $user);
    $user_lookup[trim($email)] = trim($pseudo);
}

$messages = file('messages.txt', FILE_IGNORE_NEW_LINES);
$received_messages = [];
$sent_messages = [];

foreach ($messages as $message) {
    list($from, $to, $message_text, $timestamp) = explode('|', $message);
    $from_email = trim($from);
    $to_email = trim($to);
    $message_content = trim($message_text);

    if ($to_email == $_SESSION['email']) {
        $received_messages[] = ["from" => $user_lookup[$from_email], "message" => $message_content, "timestamp" => $timestamp];
    }

    if ($from_email == $_SESSION['email']) {
        $sent_messages[] = ["to" => $user_lookup[$to_email], "message" => $message_content, "timestamp" => $timestamp];
    }
}

header('Content-Type: application/json');
echo json_encode(["received_messages" => $received_messages, "sent_messages" => $sent_messages]);
?>
