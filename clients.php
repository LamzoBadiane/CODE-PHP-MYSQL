<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Clients</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Liste des Clients</h2>
        <a href="add_client.php" class="btn btn-success mb-3">Ajouter un client</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = $conn->query("SELECT * FROM clients");
                $clients = $query->fetchAll(PDO::FETCH_ASSOC);

                foreach ($clients as $client): ?>
                    <tr>
                        <td><?= htmlspecialchars($client['id']); ?></td>
                        <td><?= htmlspecialchars($client['nom']); ?></td>
                        <td><?= htmlspecialchars($client['prenom']); ?></td>
                        <td><?= htmlspecialchars($client['email']); ?></td>
                        <td><?= htmlspecialchars($client['telephone']); ?></td>
                        <td><?= htmlspecialchars($client['adresse']); ?></td>
                        <td>
                            <a href="edit_client.php?id=<?= $client['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="delete_client.php?id=<?= $client['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
