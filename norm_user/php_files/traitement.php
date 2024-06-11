<?php
include('../../entete/connexion_base_données.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../html_file/connexion.html.php");
    exit();
}
$pseudo = $_SESSION['username'];

// Fetch the user information
$sql0 = "SELECT * FROM utilisateurs WHERE pseudo='$pseudo'";
$result0 = $conn->query($sql0);
$user = $result0->fetch_assoc();
$userId = $user['id'];

// Fetch or create the user profile
$sql = "SELECT * FROM profils WHERE utilisateur_id = $userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $profil = $result->fetch_assoc();
} 
// Update profile information
    $gender = $conn->real_escape_string($_POST['gender']);
    $taille = $conn->real_escape_string($_POST['taille']);
    $Poids = $conn->real_escape_string($_POST['Poids']);
    $Fonction = $conn->real_escape_string($_POST['Fonction']);
    $date_naissance = $conn->real_escape_string($_POST['date_naissance']);
    $Situation_amoureuse = $conn->real_escape_string($_POST['Situation_amoureuse']);

    // Handle file upload
    if (isset($_FILES['photo_profil']) && $_FILES['photo_profil']['error'] == 0) {
        $target_dir = "../images/";
        $target_file = $target_dir . basename($_FILES['photo_profil']['name']);
        move_uploaded_file($_FILES['photo_profil']['tmp_name'], $target_file);
        $photo_profil = $conn->real_escape_string($target_file);
    } else {
        $photo_profil = $profil['photo'];
    }

    // Update the profile in the database
    $sql_update = "UPDATE profils SET 
        photo='$photo_profil',
        taille='$taille',
        poids='$Poids',
        profession='$Fonction',
        Situation_familiale='$Situation_amoureuse'
        WHERE utilisateur_id=$userId";
        
    if ($conn->query($sql_update) === TRUE) {
        echo "Mise à jour réussie.";
    } else {
        echo "Erreur lors de la mise à jour : " . $conn->error;
    }

    $sql_update1 = "UPDATE utilisateurs SET 
        date_naissance='$date_naissance',
        sexe='$gender',
        WHERE id=$userId";
        
    if ($conn->query($sql_update1) === TRUE) {
        
    } else {
        echo "Erreur lors de la mise à jour : " . $conn->error;
    }


$conn->close();

?>
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
$file = 'profiles.json';
file_put_contents($file, $json_data);
header("Location:EntryProg.php");
echo "Données sauvegardées avec succès.";
?>

