<?php
session_start();
$pseudo = $_SESSION['username'];
$notificationFile = "notifications_$pseudo.txt";

if (file_exists($notificationFile)) {
    $notifications = file($notificationFile, FILE_IGNORE_NEW_LINES);
    $output = "";
    foreach ($notifications as $notification) {
        // Supposons que le format de la notification soit : "<expéditeur> vous a envoyé une demande d'amitié."
        list($from, $message) = explode(' ', $notification, 2);
        $output .= "<div class='notification'>
            <strong>$from</strong> $message
            <a href='profile_display.php?user=$from'>Voir le profil</a>
        </div>";
    }
    echo $output;
} else {
    echo "Aucune notification";
}
?>

