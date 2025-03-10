<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Documents</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Liste des Documents</h2>
        <a href="add_document.php" class="btn btn-success mb-3">Ajouter un document</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Fichier</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = $conn->query("SELECT * FROM documents");
                $documents = $query->fetchAll(PDO::FETCH_ASSOC);

                foreach ($documents as $doc): ?>
                    <tr>
                        <td><?= htmlspecialchars($doc['id']); ?></td>
                        <td><?= htmlspecialchars($doc['titre']); ?></td>
                        <td><?= htmlspecialchars($doc['description']); ?></td>
                        <td><a href="uploads/<?= htmlspecialchars($doc['fichier']); ?>" target="_blank">Voir le fichier</a></td>
                        <td><?= htmlspecialchars($doc['date_creation']); ?></td>
                        <td>
                            <a href="edit_document.php?id=<?= $doc['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="delete_document.php?id=<?= $doc['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>