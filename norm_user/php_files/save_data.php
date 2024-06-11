<!DOCTYPE html>
<html>
<body>

<?php
// Récupération des données du formulaire
$photo_profil = $_FILES['photo_profil']['name'];
$gender = $_POST['gender'];
$taille = $_POST['taille'];
$Poids = $_POST['Poids'];
$Fonction = $_POST['Fonction'];
$date_naissance = $_POST['date_naissance'];
$Signe_Astrologique = $_POST['Signe_Astrologique'];
$Situation_amoureuse = $_POST['Situation_amoureuse'];
$comment = $_POST['comment'];

// Création d'un tableau associatif avec les données
$data = array(
    'Photo de profil' => $photo_profil,
    'Sexe' => $gender,
    'Taille' => $taille,
    'Poids' => $Poids,
    'Fonction' => $Fonction,
    'Date de Naissance' => $date_naissance,
    'Signe Astrologique' => $Signe_Astrologique,
    'Situation amoureuse / familiale' => $Situation_amoureuse,
    'Traits de caractère' => $comment
);

// Conversion du tableau associatif en format JSON
$json_data = json_encode($data);

// Écriture des données dans un fichier JSON
$file = 'profile.json';
file_put_contents($file, $json_data);

echo "Données sauvegardées avec succès.";
?>
<br><br>
<button><a href="profile_display.html"><i></i> Compte</a></button>
<button><a href="EntryProg.php"><i></i> Retour à l'acceuil</a></button>
</body>
</html>

