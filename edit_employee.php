<?php include 'db.php'; ?>

<?php
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->execute([$id]);
$employee = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $poste = $_POST['poste'];
    $date_embauche = $_POST['date_embauche'];

    $sql = "UPDATE employees SET nom = ?, prenom = ?, email = ?, poste = ?, date_embauche = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nom, $prenom, $email, $poste, $date_embauche, $id]);

    header('Location: employees.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Employé</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Modifier un Employé</h2>
        <?php if (!empty($message)) echo $message; ?>
        <form method="POST" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($employee['nom']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" value="<?= htmlspecialchars($employee['prenom']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($employee['email']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="poste" class="form-label">Poste</label>
                <input type="text" name="poste" value="<?= htmlspecialchars($employee['poste']) ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label for="date_embauche" class="form-label">Date d'embauche</label>
                <input type="date" name="date_embauche" value="<?= htmlspecialchars($employee['date_embauche']) ?>" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary w-100">Modifier</button>
        </form>
    </div>
</body>
</html>
