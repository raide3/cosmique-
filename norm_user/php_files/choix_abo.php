<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: connexion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Abonnement</title>
    <link rel="stylesheet" href="../css_files/choix_abo.css">
</head>
<body>
    <div class="container">
        <h1>Choisissez votre formule d'abonnement</h1>
        <div class="plans">
            <div class="plan" onclick="location.href='payment.php?plan=jour'">
                <h2>Abonnement Jour</h2>
                <p>1 EUR / jour</p>
            </div>
            <div class="plan" onclick="location.href='payment.php?plan=mois'">
                <h2>Abonnement Mois</h2>
                <p>20 EUR / mois</p>
            </div>
            <div class="plan" onclick="location.href='payment.php?plan=an'">
                <h2>Abonnement Année</h2>
                <p>200 EUR / an</p>
            </div>
        </div>
    </div>
</body>
</html>
