<?php
session_start();
if (!isset($_SESSION['pseudo'])) {
    header("Location: connexion.php");
    exit();
}

include('../../entete/connexion_base_données.php'); 
$pseudo = $_SESSION['pseudo'];
$idi = $_GET['identifiant'] ?? null;
$_SESSION['idi'] = $idi;

if (isset($_POST['envoyer'])) {
    envoyerMessage($conn, $pseudo, $idi, $_POST['contenu']);
}

function envoyerMessage($conn, $pseudo, $idi, $contenu) {
    $sql = "INSERT INTO messages (expediteur_id, destinataire_id, contenu) VALUES ((SELECT id FROM utilisateurs WHERE pseudo=?), ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $pseudo, $idi, $contenu);

    if ($stmt->execute()) {
        echo "Message envoyé";
    } else {
        echo "Erreur: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css_files/messagerie_s.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="main.php">Page Principale</a></li>
            <li><a href="members.php">Voir les membres</a></li>
            <li><a href="b_messagerie.php">Messagerie</a></li>
            <li><a href="choix_abo.php">S'abonner</a></li>
        </ul>
    </nav>

    <div class="container">
        <section id="messages"></section>
        <form action="" method="post">
            <textarea id="contenu" name="contenu" placeholder="Écrivez votre message ici..." required></textarea><br>
            <button type="submit" name="envoyer">Envoyer</button>
        </form>
    </div>
    <a id="bas"></a>
    
        <div id="report-form" style="display: none;">
        <h3>Signaler un message</h3>
        <form action="report_message.php" method="post">
            <input type="hidden" name="message_id" id="report-message-id">
            <label for="reason">Motif du signalement :</label>
            <select name="reason" id="reason" required>
                <option value="spam">Spam</option>
                <option value="harassment">Harcèlement</option>
                <option value="offensive_language">Langage offensant</option>
            </select>
            <button type="submit">Envoyer</button>
        </form>
    </div>
    
    <script>
        $(document).ready(function() {
            function loadMessages() {
                $.ajax({
                    url: 'messagerie_s.php',
                    success: function(data) {
                        if ($('#messages').html() !== data) {
                            $('#messages').html(data);
                            attachDeleteHandlers();
                            attachReportHandlers();
                        }
                    }
                });
            }

            function attachDeleteHandlers() {
                $('.delete-btn').off('click').on('click', function() {
                    const messageId = $(this).data('message-id');
                    $.ajax({
                        type: 'POST',
                        url: 'delete.php',
                        data: { message_id: messageId },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#message-' + messageId).remove();
                            } else {
                                alert('Erreur: ' + response.message);
                            }
                        }
                    });
                });
            }

            function attachReportHandlers() {
                $('.report-btn').off('click').on('click', function() {
                    const messageId = $(this).data('message-id');
                    $('#report-message-id').val(messageId);
                    $('#report-form').show();
                });
            }

            $('#message-form').on('submit', function(event) {
                event.preventDefault();
                const messageContent = $('#contenu').val();
                $.ajax({
                    type: 'POST',
                    url: '',
                    data: $(this).serialize(),
                    success: function(response) {
                        loadMessages();
                        $('#contenu').val('');
                    }
                });
            });

            loadMessages();
            setInterval(loadMessages, 200);
        });
    </script>
</body>
</html>


