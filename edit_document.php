<?php include 'db.php'; ?>

<?php
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM documents WHERE id = ?");
$stmt->execute([$id]);
$doc = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $description = $_POST['description'];

    if (!empty($_FILES['fichier']['name'])) {
        $fichier = $_FILES['fichier']['name'];
        $tmp_name = $_FILES['fichier']['tmp_name'];
        move_uploaded_file($tmp_name, "uploads/$fichier");
    } else {
        $fichier = $doc['fichier'];
    }

    $sql = "UPDATE documents SET titre = ?, description = ?, fichier = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$titre, $description, $fichier, $id]);

    header('Location: documents.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un document</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Modifier un document</h2>
        <?php if (!empty($message)) echo $message; ?>
        <form method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" value="<?= isset($doc['titre']) ? htmlspecialchars($doc['titre']) : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4"><?= isset($doc['description']) ? htmlspecialchars($doc['description']) : '' ?></textarea>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Fichier</label>
                <input type="file" name="fichier" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary w-100">Modifier</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>