<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: connexion.html");
    exit();
}

$users = file('utilisateurs.txt', FILE_IGNORE_NEW_LINES);
$user_lookup = [];
foreach ($users as $user) {
    list($sexe, $prenom, $nom, $autre, $naissance, $ville, $code_postal, $image_profil, $email, $mot_de_passe, $offre) = explode(',', $user);
    $user_lookup[$email] = $prenom . ' ' . $nom;
}

$messages = file('messages.txt', FILE_IGNORE_NEW_LINES);
$received_messages = [];
$sent_messages = [];

foreach ($messages as $message) {
    list($from, $to, $message_text) = explode(',', $message);
    $from_email = trim(substr($from, 6));
    $to_email = trim(substr($to, 4));
    $message_content = trim(substr($message_text, 9));

    if ($to_email == $_SESSION['email']) {
        $received_messages[] = ["from" => $user_lookup[$from_email], "message" => $message_content];
    }

    if ($from_email == $_SESSION['email']) {
        $sent_messages[] = ["to" => $user_lookup[$to_email], "message" => $message_content];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Messagerie - Cy-Sport</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .header {
            background-color: black;
            padding: 10px 20px;
            text-align: center;
            position: relative;
        }

        .header h1 {
            color: white;
            margin: 0;
        }

        .back-button {
            position: absolute;
            top: 10px;
            left: 20px;
            background-color: blue;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: darkblue;
        }

        .content {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .messages-container {
            width: 60%;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
        }

        .messages-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .message-list {
            list-style-type: none;
            padding: 0;
        }

        .message-item {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }

        .message-item:last-child {
            border-bottom: none;
        }

        .message-from, .message-to {
            font-weight: bold;
        }

        .message-content {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="page_profil.php" class="back-button">Retour</a>
        <h1>Messagerie</h1>
    </div>

    <div class="content">
        <div class="messages-container">
            <h2>Messages Reçus</h2>
            <ul class="message-list">
                <?php
                if (empty($received_messages)) {
                    echo "<p>Aucun message reçu.</p>";
                } else {
                    foreach ($received_messages as $msg) {
                        echo "<li class='message-item'><span class='message-from'>De: " . htmlspecialchars($msg['from']) . "</span><p class='message-content'>" . htmlspecialchars($msg['message']) . "</p></li>";
                    }
                }
                ?>
            </ul>

            <h2>Messages Envoyés</h2>
            <ul class="message-list">
                <?php
                if (empty($sent_messages)) {
                    echo "<p>Aucun message envoyé.</p>";
                } else {
                    foreach ($sent_messages as $msg) {
                        echo "<li class='message-item'><span class='message-to'>À: " . htmlspecialchars($msg['to']) . "</span><p class='message-content'>" . htmlspecialchars($msg['message']) . "</p></li>";
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>

	

