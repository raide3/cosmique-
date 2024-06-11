<?php include('../../entete/connexion_base_données.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    
    <link rel="stylesheet" href="../css_files/connexionp.css">
    <title>Connexion - Cosmo Love</title>

</head>
<body >

    <form action="connexion.php" method="post">
        <h2>Connexion - Cosmo Love</h2>
        <label for="pseudo">Pseudonyme :</label>
        <input type="text" id="pseudo" name="pseudo" required>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <div class="forgot-password">
            <a href="forgot_password.html"> Mot de passe oublié ? </a>
        </div>
        <div class="payment-code">
            <label for="code">Code d' accès :</label>
            <input type="text" id="code" name="code">
        </div>
        <input type="submit" name= "connecter" value="Se connecter">
    </form>
    
</body>
</html>

<?php
session_start();

if (isset($_POST['connecter'])) {
    $pseudo = $_POST['pseudo'];
    $mot_de_passe = $_POST['password'];
		
    $sql = "SELECT * FROM utilisateurs WHERE pseudo='$pseudo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($mot_de_passe, $row['mot_de_passe'])) {
            $_SESSION['pseudo'] = $pseudo;
            echo "bon mot de passe"; echo "	acces expiré";
            if ($row['role'] == $_POST['code'] ) {
            	$_SESSION['code'] = $_POST['code'];
                header("Location: main_admin.php");
            } else if ($row['code_acces'] == $_POST['code'] && strtotime($row['date_expiration']) > time()) {
            	echo $row['code_acces'];
            	$_SESSION['code'] = $_POST['code'];
                header("Location: main.php");
            }else{
                header("Location: connexion.php");
            }
        } else {
            echo "Mot de passe incorrect";
        }
    } else {
        echo "Pseudo incorrect";
    }

    $conn->close();
}

?>
