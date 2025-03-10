<?php include 'db.php'; ?>

<?php
$id = $_GET['id'];
$sql = "DELETE FROM clients WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
header('Location: clients.php');
?>
