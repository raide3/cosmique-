<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css"> <!-- Ajoutez ici votre feuille de style -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f7f7f7;
             background-image: url('../images/cosmos.jpg'); 
             background-size: cover;
      background-repeat: no-repeat;
        }
        form {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
        }
        input[type="file"] {
            margin-bottom: 10px;
        }
        input[type="radio"],
        select,
        input[type="text"] {
            margin-bottom: 10px;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<form method="post" action="traitement.php" enctype="multipart/form-data">
    <h2>Finaliser votre profil</h2>
   <label for="photo_profil">
    <img src="pdp.webp" height="150px" width="150px"/> <!-- Ajustez les dimensions pour qu'elles soient visibles -->
    <br>
    Photo de Profil :
</label>              
<input type="file" id="photo_profil" name="photo_profil">

     <br>
      <br>
    <label for="gender">Sexe :</label>
    <input type="radio" name="gender" value="Homme" > Homme
    <input type="radio" name="gender" value="Femme" checked> Femme
    <br>
    <br>
    <label for="comment">Taille :</label><br>
    <input type="text" id="taille" name="taille" value="Votre taille"  >
    <br>
    <label for="comment">Poids :</label><br>
    <input type="text" id="Poids" name="Poids" value="Votre poids"  >
    <br>
    <label for="Fonction">Fonction :</label><br>
    <select name="Fonction">
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
    </select>
    <br>
    <label for="date_naissance">Date de Naissance :</label><br>
    <input type="date" id="date_naissance" name="date_naissance">
    <br>
    <br>
    <label for="Signe_Astrologique">Signe Astrologique :</label><br>
    <select name="Signe_Astrologique">
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
    </select>
    <br>
    <label for="Situation amoureuse / familiale">Situation amoureuse / familiale :</label><br>
    <select name="Situation_amoureuse">
        <option>célibataire</option>
        <option>en couple</option>
        <option>marié(e)</option>
        <option>divorcé(é)</option>
         <option>fiancé</option>
          <option>Pas besoin de déclarer</option>
        </select>
    <br>
    <label for="comment">traits de caractère :</label><br>
    <input type="text" id="comment" name="comment" value="Tapez votre commentaire"  >
    <br>
    <input type="submit" value="Valider">
</form>

</body>
</html>

