<?php include 'db.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $description = $_POST['description'];

    $fichier = $_FILES['fichier']['name'];
    $tmp_name = $_FILES['fichier']['tmp_name'];
    move_uploaded_file($tmp_name, "uploads/$fichier");

    $sql = "INSERT INTO documents (titre, description, fichier) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$titre, $description, $fichier]);

    header('Location: documents.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Documents</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SmarttechApp</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="employees.php">Employés</a></li>
                    <li class="nav-item"><a class="nav-link" href="clients.php">Clients</a></li>
                    <li class="nav-item"><a class="nav-link active" href="documents.php">Documents</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Ajouter un Document</h2>
        <?php if (!empty($message)) echo $message; ?>
        <form method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" name="titre" id="titre" class="form-control" placeholder="Titre du document" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" placeholder="Description du document"></textarea>
            </div>
            <div class="mb-3">
                <label for="fichier" class="form-label">Fichier</label>
                <input type="file" name="fichier" id="fichier" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ajouter</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
