<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord utilisateur</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Utilisateur - SmarttechApp</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="register.php">Inscription</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Connexion</a></li>
                <li class="nav-item"><a class="nav-link btn btn-danger text-white" href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Bienvenue, cher Utilisateur</h1>
        <div class="text-center mt-4">
            <a href="documents.php" class="btn btn-warning btn-lg">Voir mes documents</a>
        </div>
    </div>
</body>
</html>