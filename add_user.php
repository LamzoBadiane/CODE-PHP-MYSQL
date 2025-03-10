<?php
include 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    try {
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $email, $password, $role]);

        $message = '<div class="alert alert-success">Utilisateur ajouté avec succès !</div>';
        header('Location: users.php');
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Code erreur pour clé unique violée
            $message = '<div class="alert alert-danger">Cet email est déjà utilisé, veuillez en choisir un autre.</div>';
        } else {
            $message = '<div class="alert alert-danger">Une erreur est survenue : ' . $e->getMessage() . '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Ajouter un utilisateur</h2>
        <?= $message; ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Nom" class="form-control mb-3" required>
            <input type="email" name="email" placeholder="Email" class="form-control mb-3" required>
            <input type="password" name="password" placeholder="Mot de passe" class="form-control mb-3" required>
            <select name="role" class="form-control mb-3" required>
                <option value="user">Utilisateur</option>
                <option value="admin">Administrateur</option>
            </select>
            <button type="submit" class="btn btn-primary w-100">Ajouter</button>
        </form>
    </div>
</body>
</html>
