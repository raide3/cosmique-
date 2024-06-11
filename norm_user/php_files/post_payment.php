<?php
session_start();
include('../../entete/connexion_base_données.php');

if (!isset($_SESSION['username'])) {
    header("Location: connexion.php");
    exit();
}

$pseudo = $_SESSION['username'];
$plan = $_POST['plan'];

$prix = [
    'jour' => 1,
    'mois' => 20,
    'an' => 200
];

$duree = [
    'jour' => '+1 day',
    'mois' => '+1 month',
    'an' => '+1 year'
];

if (!isset($prix[$plan]) || !isset($duree[$plan])) {
    echo "Plan invalide.";
    exit();
}



    $code_acces = bin2hex(random_bytes(8)); // Generate a random access code
    $date_expiration = date('Y-m-d H:i:s', strtotime($duree[$plan]));

    // Update user's access code and expiration date
 $stmt = $conn->prepare("UPDATE utilisateurs SET code_acces = ?, date_expiration = ? WHERE pseudo = ?");
  $stmt->bind_param("sss", $code_acces, $date_expiration, $pseudo);
    $stmt->execute();

    echo "<div class='container'>";
    echo "<h2 class='text-center'>Paiement réussi!</h2>";
    echo "<p>Votre code d'accès: <strong>$code_acces</strong></p>";
    echo "<p>Valide jusqu'au: <strong>$date_expiration</strong></p>";
    echo "<a href='../../abo_user/php_files/connexion.php' class='btn btn-primary'>Retour à la page principale</a>";
    echo "</div>";

$sql = "UPDATE utilisateurs SET code_acces = NULL, date_expiration = NULL WHERE date_expiration < NOW()";
$conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat du Paiement</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: AliceBlue;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
</body>
</html>

