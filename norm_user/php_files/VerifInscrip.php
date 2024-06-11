<?php include('../../entete/connexion_base_données.php'); ?>
<?php
if (isset($_POST['ok'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $sexe = $_POST['gender'];
    $date_naissance = $_POST['date_naissance'];

    $sql = "INSERT INTO utilisateurs (nom,prenom,pseudo, mot_de_passe, email, sexe, date_naissance) VALUES ('$nom','$prenom','$pseudo', '$mot_de_passe', '$email', '$sexe', '$date_naissance')";
    if ($conn->query($sql) === TRUE) {
        echo "Inscription réussie";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
    
     $userId = $conn->insert_id;
    
$sql = "SELECT * FROM profils WHERE utilisateur_id = $userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $profil = $result->fetch_assoc();
} else {
    // Si l'utilisateur n'a pas encore de profil, on en crée un vide
    $conn->query("INSERT INTO profils (utilisateur_id) VALUES ($userId)");
    $profil = ['profession' => '', 'lieu_residence' => '', 'situation_familiale' => '', 'description_physique' => '', 'informations_personnelles' => '', 'photo' => ''];
}
	

        $photo = 'inconnu.png'; // Default image if no file uploaded
    
	
	
    // Mettre à jour les informations de profil
    $profession = isset($_POST['fonction']) ? $_POST['fonction'] : '';
    $situation_familiale = isset($_POST['situation_amoureuse']) ? $_POST['situation_amoureuse'] : '';
	$taille=isset($_POST['taille'])?$_POST['taille']:'';
	$poids=isset($_POST['poids'])?$_POST['poids']:'';
    $sql0 = "UPDATE profils SET profession='$profession',  situation_familiale='$situation_familiale', photo='$photo', poids='$poids', taille='$taille' WHERE utilisateur_id = $userId";

    if ($conn->query($sql0) === TRUE) {
        echo "Profil mis à jour";
    } else {
        echo "Erreur lors de la mise à jour du profil: " . $conn->error;
    }
    $conn->close();
	
}
?>

<?php
if (isset($_POST['ok'])) {
    // Sanitize and collect form data
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $pass = htmlspecialchars($_POST['pass']);
    $gender = htmlspecialchars($_POST['gender']);
    $taille = htmlspecialchars($_POST['taille']);
    $poids = htmlspecialchars($_POST['poids']);
    $fonction = htmlspecialchars($_POST['fonction']);
    $date_naissance = htmlspecialchars($_POST['date_naissance']);
    $signe_astrologique = htmlspecialchars($_POST['signe_astrologique']);
    $situation_amoureuse = htmlspecialchars($_POST['situation_amoureuse']);
    


    // Prepare data string
    $data = $nom . ',' . $prenom . ',' . $email . ',' . $pseudo . ',' . $pass . ',' . $gender . ',' . $taille . ',' . $poids . ',' . $fonction . ',' . $date_naissance . ',' . $signe_astrologique . ',' . $situation_amoureuse . ',' . PHP_EOL;

    // Append data to the file
    $filename = 'utilisateurs.txt';
    file_put_contents($filename, $data, FILE_APPEND | LOCK_EX);

    // Output message and redirect
    echo "Inscription réussie. Redirection vers la page de connexion...";
    header("Refresh: 3; URL=../html_files/connexion.html");
    exit();
}


?>

