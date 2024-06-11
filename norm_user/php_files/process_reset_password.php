<?php
if (isset($_POST['email']) && isset($_POST['new_password'])) {
    $email = trim($_POST['email']);
    $new_password = trim($_POST['new_password']);

    // Vérifier si les champs ne sont pas vides
    if (empty($email) || empty($new_password)) {
        echo "Erreur : Adresse e-mail et mot de passe ne peuvent pas être vides.";
        exit;
    }

    $filename = 'utilisateurs.txt';
    if (file_exists($filename)) {
        $utilisateurs = file($filename, FILE_IGNORE_NEW_LINES);
        $updatedUsers = [];
        $passwordReset = false;

        foreach ($utilisateurs as $utilisateur) {
            list($nom, $prenom, $existingEmail, $pseudo, $pass, $sexe) = explode(',', $utilisateur);

            if (strcasecmp(trim($existingEmail), trim($email)) == 0) {
                $updatedUsers[] = "$nom,$prenom,$existingEmail,$pseudo,$new_password,$sexe";
                $passwordReset = true;
            } else {
                $updatedUsers[] = $utilisateur;
            }
        }

        if ($passwordReset) {
            file_put_contents($filename, implode(PHP_EOL, $updatedUsers) . PHP_EOL);
            echo "Mot de passe réinitialisé avec succès.";
            // Redirection après 3 secondes
            header("refresh:3;url=connexion.html");
            exit;
        } else {
            echo "Erreur : Adresse e-mail non trouvée.";
        }
    } else {
        echo "Erreur : Fichier utilisateurs.txt non trouvé.";
    }
} else {
    echo "Veuillez fournir une adresse e-mail et un nouveau mot de passe.";
}
?>


