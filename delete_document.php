<?php include 'db.php'; ?>

<?php
$id = $_GET['id'];
$sql = "DELETE FROM documents WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
header('Location: documents.php');
?>
