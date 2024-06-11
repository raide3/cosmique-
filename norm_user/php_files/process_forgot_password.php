<?php
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Lire le fichier utilisateurs.txt
    $filename = 'utilisateurs.txt';
    $userFound = false;

    if (file_exists($filename)) {
        $utilisateurs = file($filename, FILE_IGNORE_NEW_LINES);
        foreach ($utilisateurs as $utilisateur) {
            list($nom, $prenom, $existingEmail, $pseudo, $pass, $sexe) = explode(',', $utilisateur);
            if ($existingEmail == $email) {
                // Simulation d'envoi de l'e-mail de réinitialisation
                echo "Un e-mail de réinitialisation de mot de passe a été envoyé à $email.";
                $userFound = true;
                break;
            }
        }
    }

    if (!$userFound) {
        echo "Cette adresse e-mail n'est pas enregistrée.";
    } else {
        // Attendre 3 secondes avant de rediriger
        header("refresh:3;url=/reset_password.html?email=$email");
    }
} else {
    echo "Veuillez fournir une adresse e-mail.";
}
?>

