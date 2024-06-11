<?php
session_start();

    $pseudo = $_POST['pseudo'];
    $mot_de_passe = $_POST['password'];
		
    $sql = "SELECT * FROM utilisateurs WHERE pseudo='$pseudo'";
    $result = $conn->query($sql);
 echo "bon mot de passe";
    if (1) {
        $row = $result->fetch_assoc();
        if (1) {
            $_SESSION['pseudo'] = $pseudo;
            echo "	acces expiré";
            if (1) {
            	$_SESSION['code'] = $_POST['code'];
                header("Location: main_admin.php");
            } else if ($row['code_acces'] == $_POST['code'] && $row['date_expiration'] < NOW()) {
            	
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

?>
