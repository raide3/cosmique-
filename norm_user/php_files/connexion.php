<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $login = $_POST['login'];
    $password = $_POST['password'];

   
    $filename = 'utilisateurs.txt';

 
    $lines = file($filename, FILE_IGNORE_NEW_LINES);

    $loggedIn = false;
    foreach ($lines as $line) {
        $userData = explode(',', $line);
        $pseudo = trim($userData[3]); // Utiliser trim() pour supprimer les espaces éventuels
        $pass = trim($userData[4]); // Utiliser trim() pour supprimer les espaces éventuels

        
        if ($login == $pseudo && $password == $pass) { // Comparaison sans hachage de mot de passe
            // L'utilisateur est connecté avec succès
            $loggedIn = true;
            break;
        }
    }

    if ($loggedIn) {
      
        session_start();
      
        $_SESSION['username'] = $pseudo;
     
        header("Location: EntryProg.php");
        exit(); // Arrêter l'exécution du script après la redirection
    } else {
     
        echo "Échec de la connexion. Veuillez vérifier vos informations.";
    }
}
?>

