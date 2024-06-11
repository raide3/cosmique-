<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["photo_profil"])) {
    $file_name = $_FILES["photo_profil"]["name"];
    $file_tmp = $_FILES["photo_profil"]["tmp_name"];
    $file_type = $_FILES["photo_profil"]["type"];
    $file_size = $_FILES["photo_profil"]["size"];
    
    // Vérification du type de fichier (optionnel)
    $allowed_types = array("image/jpeg", "image/png", "image/gif");
    if (!in_array($file_type, $allowed_types)) {
        echo "Seuls les fichiers JPEG, PNG et GIF sont autorisés.";
        exit;
    }
    
    // Déplacement du fichier téléchargé vers le répertoire souhaité
    $upload_dir = "uploads/";
    $destination = $upload_dir . $file_name;
    if (move_uploaded_file($file_tmp, $destination)) {
        echo "Le fichier a été téléchargé avec succès.";
        // Vous pouvez enregistrer le chemin du fichier dans une base de données ou autre stockage
    } else {
        echo "Erreur lors du téléchargement du fichier.";
    }
}
?>

