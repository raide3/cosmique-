<?php
session_start();
if (!isset($_SESSION['pseudo'])) {
    header("Location: connexion.php");
    exit();
}

include('../../entete/connexion_base_données.php'); 
$pseudo = $_SESSION['pseud'];
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
            <li><a href="member_admin.php">Gérer les profils</a></li>
            <li><a href="moderation.php">Gérer les messages</a></li>
            <li><a href="main.php">simulation membre premium</a></li>
        </ul>
    </nav>
    <div class="container">
        <section id="messages"></section>
        <form action="" method="post">

            
        </form>
    </div>
    <a id="bas"></a>
    

    
    <script>
        $(document).ready(function() {
            function loadMessages() {
                $.ajax({
                    url: 'messagerie_s_admin.php',
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


