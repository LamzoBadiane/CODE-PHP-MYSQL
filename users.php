<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
include 'db.php';

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Filtres
$search = $_GET['search'] ?? '';
$roleFilter = $_GET['role'] ?? '';

$where = "WHERE 1=1";
$params = [];
if ($search) {
    $where .= " AND (name LIKE ? OR email LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
if ($roleFilter) {
    $where .= " AND role = ?";
    $params[] = $roleFilter;
}

// Récupérer les utilisateurs avec pagination
$stmt = $conn->prepare("SELECT * FROM users $where LIMIT $limit OFFSET $offset");
$stmt->execute($params);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Nombre total d'utilisateurs
$totalStmt = $conn->prepare("SELECT COUNT(*) FROM users $where");
$totalStmt->execute($params);
$totalUsers = $totalStmt->fetchColumn();
$totalPages = ceil($totalUsers / $limit);

// Validation avancée côté serveur
function validateUserInput($name, $email, $password) {
    if (strlen($name) < 3) {
        return "Le nom doit contenir au moins 3 caractères.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "L'email n'est pas valide.";
    }
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        return "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial.";
    }
    return null;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion avancée des Utilisateurs</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Gestion avancée des Utilisateurs</h2>
        <form method="GET" class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="search" placeholder="Rechercher par nom ou email" value="<?= htmlspecialchars($search) ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <select name="role" class="form-control">
                    <option value="">Tous les rôles</option>
                    <option value="admin" <?= $roleFilter === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="user" <?= $roleFilter === 'user' ? 'selected' : '' ?>>Utilisateur</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
            </div>
        </form>

        <a href="add_user.php" class="btn btn-success mb-3">Ajouter un utilisateur</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']); ?></td>
                        <td><?= htmlspecialchars($user['name']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td>
                            <form method="POST" action="update_role.php" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                <select name="role" onchange="this.form.submit()" class="form-select">
                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Utilisateur</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="edit_user.php?id=<?= $user['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="delete_user.php?id=<?= $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&search=<?= htmlspecialchars($search) ?>&role=<?= htmlspecialchars($roleFilter) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</body>
</html>
