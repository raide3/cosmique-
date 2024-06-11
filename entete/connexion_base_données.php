<?php
$servername = "localhost";
$username = "michelle";
$password = "azerty2.n";
$dbname = "site_de_rencontre_cosmologie";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

