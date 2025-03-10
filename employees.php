<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Employés</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Liste des Employés</h2>
        <a href="add_employee.php" class="btn btn-success mb-3">Ajouter un employé</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Poste</th>
                    <th>Date d'embauche</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = $conn->query("SELECT * FROM employees");
                $employees = $query->fetchAll(PDO::FETCH_ASSOC);

                foreach ($employees as $employee): ?>
                    <tr>
                        <td><?= htmlspecialchars($employee['id']); ?></td>
                        <td><?= htmlspecialchars($employee['nom']); ?></td>
                        <td><?= htmlspecialchars($employee['prenom']); ?></td>
                        <td><?= htmlspecialchars($employee['email']); ?></td>
                        <td><?= htmlspecialchars($employee['poste']); ?></td>
                        <td><?= htmlspecialchars($employee['date_embauche']); ?></td>
                        <td>
                            <a href="edit_employee.php?id=<?= $employee['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="delete_employee.php?id=<?= $employee['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
