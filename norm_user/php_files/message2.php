Ghilas Bougdal
	
ven. 17 mai 19:09 (il y a 5 heures)
	
À moi
<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_GET['email']) || !isset($_GET['name'])) {
    header("Location: ../html_files/connexion.html");
    exit();
}

$recipient_email = $_GET['email'];
$recipient_name = $_GET['name'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];
    $sender_email = $_SESSION['email'];

    // Vous pouvez ajouter ici la logique pour enregistrer le message dans une base de données ou l'envoyer par email
    // Pour l'instant, nous allons simplement simuler l'envoi d'un message

    $filename = 'messages.txt';
    $entry = "From: $sender_email, To: $recipient_email, Message: $message\n";
    file_put_contents($filename, $entry, FILE_APPEND);

    header("Location: page_profil.php?status=success&message=" . urlencode("Message envoyé avec succès."));
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Envoyer un message - Cy-Sport</title>
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
        }

        .header h1 {
            color: white;
            margin: 0;
        }

        .content {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .message-form {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
            margin-bottom: 20px; /* Ajouter une marge en bas pour espacer le bouton du formulaire */
        }

        .message-form h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .message-form textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            height: 150px;
        }

        .message-form button {
            background-color: blue;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-top: 20px; /* Ajouter une marge en haut pour espacer le bouton du formulaire */
        }

        .message-form button:hover {
            background-color: darkblue;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Envoyer un message</h1>
    </div>

    <div class="content">
        <div class="message-form">
            <h2>À : <?php echo htmlspecialchars($recipient_name); ?></h2>
            <form action="envoyer_message.php?email=<?php echo urlencode($recipient_email); ?>&name=<?php echo urlencode($recipient_name); ?>" method="post">
                <textarea name="message" placeholder="Votre message..." required></textarea>
                <button type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</body>
</html>
	

