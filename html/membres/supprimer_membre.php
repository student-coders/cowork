<?php
require '../db.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM membres WHERE id = ?");
$stmt->execute([$id]);
header("Location: liste_membres.php");
exit();
?>