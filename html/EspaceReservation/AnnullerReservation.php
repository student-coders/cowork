<?php
require ('db.php');
$id=$_GET['id'];
$statut="annulle";
$Update=$PDO->prepare("UPDATE reservations SET statut=? WHERE id=?");
$Update->execute([$statut,$id]);
?>
