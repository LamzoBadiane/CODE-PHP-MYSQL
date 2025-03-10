<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smarttech";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p class='text-success text-center'>Connexion réussie à la base de données</p>";
} catch (PDOException $e) {
    echo "<p class='text-danger text-center'>Erreur : " . $e->getMessage() . "</p>";
}
?>