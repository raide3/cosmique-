<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialiser le mot de passe</title>
    <link rel="stylesheet" href="connexion.css"> <!-- Ajoutez ici votre feuille de style -->
</head>
<body>
    <div class="wrapper">
        <form action="process_reset_password.php" method="post">
            <h1>Nouveau mot de passe</h1>
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>"> <!-- Récupérer l'email depuis l'URL -->
            <div class="input-box">
                <input type="password" id="new_password" name="new_password" placeholder="Nouveau mot de passe" required>
            </div>
            <button type="submit" class="btn">Réinitialiser</button>
        </form>
    </div>
</body>
</html>

