<?php
session_start();
if (!isset($_SESSION['pseudo'])) {
    header("Location: connexion.php");
    exit();
}
include('../../entete/connexion_base_données.php'); 
$pseudo = $_SESSION['pseudo'];
$userId = $_GET['id'] ?? null;
$sql0 = "SELECT * FROM utilisateurs WHERE id='$userId'";
$result0 = $conn->query($sql0);
$user = $result0->fetch_assoc();
$sql = "SELECT * FROM profils WHERE utilisateur_id = $userId";
$result = $conn->query($sql);
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "../images/";
        $target_file = $target_dir . basename($_FILES['photo']['name']);
        
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            $photo = $target_file;
        } else {
            echo "Erreur lors du téléchargement de l'image.";
            exit();
        }
    } else {
        $photo = $profil['photo'];
    }
if ($result->num_rows > 0) {
    $profil = $result->fetch_assoc();
} else {
    // Si l'utilisateur n'a pas encore de profil, on en crée un vide
    $conn->query("INSERT INTO profils (utilisateur_id) VALUES ($userId)");
    $profil = ['profession' => '', 'lieu_residence' => '', 'situation_familiale' => '', 'description_physique' => '', 'informations_personnelles' => '', 'photo' => ''];
}

// Mettre à jour les informations de profil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $profession = $conn->real_escape_string($_POST['profession']);
    $lieu_residence = $conn->real_escape_string($_POST['country']);
    $situation_familiale = $conn->real_escape_string($_POST['situation_familiale']);
    $description_physique = $conn->real_escape_string($_POST['description_physique']);
    $informations_personnelles = $conn->real_escape_string($_POST['informations_personnelles']);
    

    $sql = "UPDATE profils SET profession='$profession', lieu_residence='$lieu_residence', situation_familiale='$situation_familiale', description_physique='$description_physique', informations_personnelles='$informations_personnelles', photo='$photo' WHERE utilisateur_id = (SELECT id FROM utilisateurs WHERE id = '$userId')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Profil mis à jour";
        $sql = "SELECT * FROM profils WHERE utilisateur_id = $userId";
        $result = $conn->query($sql);
        $profil = $result->fetch_assoc();
    } else {
        echo "Erreur: " . $conn->error;
    }
}
?>
<?php
function getAstrologicalSign($birthDate) {
    $date = new DateTime($birthDate);
    $month = $date->format('m');
    $day = $date->format('d');

    if (($month == 1 && $day >= 20) || ($month == 2 && $day <= 18)) {
        return "Verseau";
    } elseif (($month == 2 && $day >= 19) || ($month == 3 && $day <= 20)) {
        return "Poissons";
    } elseif (($month == 3 && $day >= 21) || ($month == 4 && $day <= 19)) {
        return "Bélier";
    } elseif (($month == 4 && $day >= 20) || ($month == 5 && $day <= 20)) {
        return "Taureau";
    } elseif (($month == 5 && $day >= 21) || ($month == 6 && $day <= 20)) {
        return "Gémeaux";
    } elseif (($month == 6 && $day >= 21) || ($month == 7 && $day <= 22)) {
        return "Cancer";
    } elseif (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)) {
        return "Lion";
    } elseif (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)) {
        return "Vierge";
    } elseif (($month == 9 && $day >= 23) || ($month == 10 && $day <= 22)) {
        return "Balance";
    } elseif (($month == 10 && $day >= 23) || ($month == 11 && $day <= 21)) {
        return "Scorpion";
    } elseif (($month == 11 && $day >= 22) || ($month == 12 && $day <= 21)) {
        return "Sagittaire";
    } elseif (($month == 12 && $day >= 22) || ($month == 1 && $day <= 19)) {
        return "Capricorne";
    } else {
        return "Date de naissance invalide";
    }
}

// Exemple d'utilisation
$birthDate = $user['date_naissance'];
$sign = getAstrologicalSign($birthDate);
function calculerAge($dateNaissance) {
    // Convertir la date de naissance en objet DateTime
    $dateNaissance = new DateTime($dateNaissance);
    // Obtenir la date actuelle
    $aujourdhui = new DateTime();
    // Calculer la différence en années
    $age = $aujourdhui->diff($dateNaissance)->y;

    return $age;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="../css_files/profil.css">
</head>
<body>

    <nav>
        <ul>
            <li><a href="member_admin.php">Gérer les profils</a></li>
            <li><a href="moderation.php">Gérer les messages</a></li>
            <li><a href="main.php">simulation membre premium</a></li>
        </ul>
    </nav>
   </body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <title>Profil de <?php echo $user['pseudo']; ?></title>
</head>
<body>    
    <div class="profile-info">     
    <?php if ($profil['photo']) { ?>
            <p><strong>Photo:</strong> <img src="<?php echo "../images/".htmlspecialchars($profil['photo']); ?>" alt="Photo de profil"></p>
        <?php } ?>
    <h1>Profil de <?php echo $user['pseudo']; ?></h1>
    <p>nom: <?php echo $user['nom']; ?></p>
    <p>prenom: <?php echo $user['prenom']; ?></p>
    <p>Email: <?php echo $user['email']; ?></p>
    <p>Sexe: <?php echo $user['sexe']; ?></p>
    <p>Date de naissance: <?php echo $user['date_naissance']; ?></p>
    <p>Âge: <?php echo calculerAge($user['date_naissance']).' ans'; ?></p>
    <p>signe astrologique: <?php echo $sign; ?></p>
    <a href="deconnexion.php">Se déconnecter</a>
       

        <p><strong>Profession:</strong> <?php echo htmlspecialchars($profil['profession']); ?></p>
        <p><strong>Lieu de résidence:</strong> <?php echo htmlspecialchars($profil['lieu_residence']); ?></p>
        <p><strong>Situation familiale:</strong> <?php echo htmlspecialchars($profil['situation_familiale']); ?></p>
        <p><strong>Description physique:</strong> <?php echo htmlspecialchars($profil['description_physique']); ?></p>
        <p><strong>Informations personnelles:</strong> <?php echo htmlspecialchars($profil['informations_personnelles']); ?></p>

    </div>
</body>
</html>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="profil.css">
</head>
<body>

    <form action="profil_admin.php?id=<?php echo $userId?>" method="post">
        <label for="profession">Profession:</label>
        <input type="text" id="profession" name="profession" value="<?php echo htmlspecialchars($profil['profession']); ?>"><br>

        <label for="lieu_residence">Lieu de résidence:</label><br><br>
        <select id="country" name="country" class="form-control" >
        	<option value="">-- Sélectionnez un pays --</option>
        </select><br><br>

        <label for="situation_familiale">Situation familiale:</label>
        <input type="text" id="situation_familiale" name="situation_familiale" value="<?php echo htmlspecialchars($profil['situation_familiale']); ?>"><br>

        <label for="description_physique">Description physique:</label>
        <textarea id="description_physique" name="description_physique"><?php echo htmlspecialchars($profil['description_physique']); ?></textarea><br>

        <label for="informations_personnelles">Informations personnelles:</label>
        <textarea id="informations_personnelles" name="informations_personnelles"><?php echo htmlspecialchars($profil['informations_personnelles']); ?></textarea><br>

        <label for="photo">Photo de profil:</label>
        <input type="file" id="photo" name="photo"><br>

        <button type="submit">Mettre à jour</button>
        
    </form>
    <a href='b_messagerie_admin.php?id=<?php echo $userId; ?>'>lien vers sa messagerie</a>

</body>
</html>

    <script>
        const countries = [
            "Afghanistan", "Albanie", "Algérie", "Samoa américaines", "Andorre", "Angola", "Anguilla", "Antarctique", "Antigua-et-Barbuda", "Argentine", "Arménie", "Aruba", "Australie", "Autriche", "Azerbaïdjan", "Bahamas", "Bahreïn", "Bangladesh", "Barbade", "Biélorussie", "Belgique", "Belize", "Bénin", "Bermudes", "Bhoutan", "Bolivie", "Bonaire, Saint-Eustache et Saba", "Bosnie-Herzégovine", "Botswana", "Brésil", "Territoire britannique de l'océan Indien", "Îles Vierges britanniques", "Brunei", "Bulgarie", "Burkina Faso", "Burundi", "Cabo Verde", "Cambodge", "Cameroun", "Canada", "Îles Caïmans", "République centrafricaine", "Tchad", "Chili", "Chine", "Île Christmas", "Îles Cocos (Keeling)", "Colombie", "Comores", "Congo", "Congo (RDC)", "Îles Cook", "Costa Rica", "Côte d'Ivoire", "Croatie", "Cuba", "Curaçao", "Chypre", "République tchèque", "Danemark", "Djibouti", "Dominique", "République dominicaine", "Équateur", "Égypte", "El Salvador", "Guinée équatoriale", "Érythrée", "Estonie", "Eswatini", "Éthiopie", "Îles Falkland", "Îles Féroé", "Fidji", "Finlande", "France", "Guyane française", "Polynésie française", "Gabon", "Gambie", 
"Géorgie", "Allemagne", "Ghana", "Gibraltar", "Grèce", "Groenland", "Grenade", "Guadeloupe", "Guam", "Guatemala", "Guernesey", "Guinée", "Guinée-Bissau", "Guyana", "Haïti", "Saint-Siège (Vatican)", "Honduras", "Hong Kong", "Hongrie", "Islande", "Inde", "Indonésie", "Iran", "Irak", "Irlande", "Île de Man", "Israël", "Italie", "Jamaïque", "Japon", "Jersey", "Jordanie", "Kazakhstan", "Kenya", "Kiribati", "Corée du Nord", "Corée du Sud", "Koweït", "Kirghizistan", "Laos", "Lettonie", "Liban", "Lesotho", "Libéria", "Libye", "Liechtenstein", "Lituanie", "Luxembourg", "Macao", "Madagascar", "Malawi", "Malaisie", "Maldives", "Mali", "Malte", "Îles Marshall", "Martinique", "Mauritanie", "Maurice", "Mayotte", "Mexique", "Micronésie", "Moldavie", "Monaco", "Mongolie", "Monténégro", "Montserrat", "Maroc", "Mozambique", "Myanmar (Birmanie)", "Namibie", "Nauru", "Népal", "Pays-Bas", "Nouvelle-Calédonie", "Nouvelle-Zélande", "Nicaragua", "Niger", "Nigeria", "Niue", "Île Norfolk", "Macedoine du Nord", "Îles Mariannes du Nord", "Norvège", "Oman", "Pakistan", "Palaos", "Palestine", "Panama", "Papouasie-Nouvelle-Guinée", "Paraguay", "Pérou", "Philippines", "Pitcairn", "Pologne", "Portugal", "Porto Rico", "Qatar", "Réunion", "Roumanie", "Russie", "Rwanda", "Sainte-Hélène", "Saint-Christophe-et-Niévès", "Sainte-Lucie", "Saint-Pierre-et-Miquelon", "Saint-Vincent-et-les Grenadines", "Samoa", "Saint-Marin", "Sao Tomé-et-Principe", "Arabie Saoudite", "Sénégal", "Serbie", "Seychelles", "Sierra Leone", "Singapour", "Sint Maarten", "Slovaquie", "Slovénie", "Îles Salomon", "Somalie", "Afrique du Sud", "Géorgie du Sud-et-les Îles Sandwich du Sud", "Soudan du Sud", "Espagne", "Sri Lanka", "Soudan", "Suriname", "Svalbard et Jan Mayen", "Suède", "Suisse", "Syrie", "Taïwan", "Tadjikistan", "Tanzanie", "Thaïlande", "Timor-Leste", "Togo", "Tokelau", "Tonga", "Trinité-et-Tobago", "Tunisie", "Turquie", "Turkménistan", "Îles Turques-et-Caïques", "Tuvalu", "Ouganda", "Ukraine", "Émirats Arabes Unis", "Royaume-Uni", "États-Unis", "Uruguay", "Ouzbékistan", "Vanuatu", "Venezuela", "Vietnam", "Îles Vierges américaines", "Sahara Occidental", "Yémen", "Zambie", "Zimbabwe"
        ];

        const countrySelect = document.getElementById('country');

        countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country;
            option.text = country;
            countrySelect.appendChild(option);
        });
    </script>
