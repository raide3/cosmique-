<?php include('../../entete/connexion_base_données.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css_files/inscription.css">
    <title>Inscription</title>
    <style>
        body {
            background-image: url('../images/cosmos.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        input {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
	
    <form method="POST" action="VerifInscrip.php" enctype="multipart/form-data">
    	<h1>Inscription</h1>
        <label for="nom">Votre Nom </label>
        <input type="text" id="nom" name="nom" placeholder="Entrer votre nom..." required><br>

        <label for="prenom">Votre Prénom </label>
        <input type="text" id="prenom" name="prenom" placeholder="Entrer votre prénom..." required><br>

        <label for="email">Votre E-mail </label>
        <input type="text" id="email" name="email" placeholder="Entrer votre E-mail..." required><br>

        <label for="pseudo">Votre Pseudo</label>
        <input type="text" id="pseudo" name="pseudo" placeholder="Entrer votre pseudo..." required><br>

        <label for="pass">Votre Mot de passe </label>
        <input type="password" id="pass" name="pass" placeholder="Entrer votre Mot de passe..." required><br>

        <!--label for="gender">Sexe :</label-->
        Homme<input type="radio" name="gender" value="Homme"> 
        Femme<input type="radio" name="gender" value="Femme" checked> <br><br>

        <label for="taille">Taille :</label><br>
        <input type="text" id="taille" name="taille" placeholder="Votre taille"><br>

        <label for="poids">Poids :</label><br>
        <input type="text" id="poids" name="poids" placeholder="Votre poids"><br>

        <label for="fonction">Fonction :</label><br>
        <select name="fonction">
            <option>Etudiant</option>
            <option>Enseignant</option>
            <option>Ingenieur</option>
            <option>Medecin</option>
            <option>Avocat</option>
            <option>Artiste</option>
            <option>Entrepreneur</option>
            <option>Developpeur</option>
            <option>Juge</option>
            <option>Autre</option>
        </select><br>

        <label for="date_naissance">Date de Naissance :</label><br>
        <input type="date" id="date_naissance" name="date_naissance"><br><br>

        <label for="signe_astrologique">Signe Astrologique :</label><br>
        <select name="signe_astrologique">
            <option>BÉLIER</option>
            <option>TAUREAU</option>
            <option>GÉMEAUX</option>
            <option>CANCER</option>
            <option>LION</option>
            <option>VIERGE</option>
            <option>BALANCE</option>
            <option>SCORPION</option>
            <option>SAGITTAIRE</option>
            <option>CAPRICORNE</option>
            <option>VERSEAU</option>
            <option>POISSON</option>
        </select><br>

        <label for="situation_amoureuse">Situation amoureuse / familiale :</label><br>
        <select name="situation_amoureuse">
            <option>célibataire</option>
            <option>en couple</option>
            <option>marié(e)</option>
            <option>divorcé(é)</option>
            <option>fiancé</option>
            <option>Pas besoin de déclarer</option>
        </select><br>

        <input type="submit" value="s'inscrire !!" name="ok">
    </form>
</body>
</html>

