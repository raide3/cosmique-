<?php
session_start();

$from_user_email = $_SESSION['email'];
$to_user_pseudo = trim($_POST['to_user_pseudo']);
$message = trim($_POST['message']);
$timestamp = date('Y-m-d H:i:s');

$users = file('utilisateurs.txt', FILE_IGNORE_NEW_LINES);
$pseudo_lookup = [];
foreach ($users as $user) {
    list($nom, $prenom, $email, $pseudo, $mdp) = explode(',', $user);
    $pseudo_lookup[trim($pseudo)] = trim($email);
}

if (isset($pseudo_lookup[$to_user_pseudo])) {
    $to_user_email = $pseudo_lookup[$to_user_pseudo];
    $entry = "$from_user_email|$to_user_email|$message|$timestamp\n";
    file_put_contents('messages.txt', $entry, FILE_APPEND);
    header("Location: messaging.html");
    exit();
} else {
    echo "Utilisateur non trouvé";
}
?>
