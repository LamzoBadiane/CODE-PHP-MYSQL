<?php include 'db.php'; ?>

<?php
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
$stmt->execute([$id]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE clients SET nom = ?, prenom = ?, email = ?, telephone = ?, adresse = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['telephone'], $_POST['adresse'], $id]);
    header('Location: clients.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un client</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Modifier un client</h2>
        <?php if (!empty($message)) echo $message; ?>
        <form method="POST" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($client['nom']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" value="<?= htmlspecialchars($client['prenom']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($client['email']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Telephone</label>
                <input type="text" name="telephone" value="<?= htmlspecialchars($client['telephone']) ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" name="adresse" value="<?= htmlspecialchars($client['adresse']) ?>" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary w-100">Modifier</button>
        </form>
    </div>
</body>
</html>

