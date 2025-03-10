<?php
include 'db.php';
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name, $email, $role, $id]);
    header('Location: users.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Modifier un utilisateur</h2>
        <form method="POST">
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
            <select name="role" required>
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>>Utilisateur</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrateur</option>
            </select>
            <button type="submit">Modifier</button>
        </form>
    </div>
</body>
</html>