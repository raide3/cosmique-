<?php
session_start();
if (!isset($_SESSION['pseudo']) || $_SESSION['code'] !== 'administrateur') {
   header("Location: connexion.php");
   exit();
}
?>

<?php
session_start();

include('../../entete/connexion_base_données.php');

$sql = "SELECT * FROM utilisateurs";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="../css_files/main_admin.css">
</head>
<body>

        <nav>
        <ul>
            <li><a href="member_admin.php">Gérer les profils</a></li>
            <li><a href="moderation.php">Gérer les messages</a></li>
            <li><a href="main.php">simulation membre premium</a></li>
        </ul>
    </nav>    
    <h1>Bienvenue, Administrateur <?= $_SESSION['pseudo']?></h1>
    <p>Vous avez accès à toutes les fonctionnalités administratives.</p>
   
    
     <h1>Lite Utilisateurs</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Pseudo</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Date de Création</th>
            <th>Date expiration abonnement</th>
        </tr>
        <?php while ($user = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['pseudo']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td><?php echo $user['date_inscription']; ?></td>
                <td><?php echo $user['date_expiration']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

