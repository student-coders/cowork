<?php
require 'db.php';

$reservations = $PDO->query("
    SELECT r.*, m.nom, m.prenom ,e.typee,e.capacite
    FROM reservations r
    JOIN membres m ON r.membre_id = m.id 
    JOIN espaces e ON r.espace_id=e.id
    WHERE r.statut= 'confirmer'
    ORDER BY r.date_reservation
")->fetchAll();
$delete=$PDO->prepare("DELETE FROM reservations WHERE date_reservation<?");
$date=date("Y-m-d");
$delete->execute([$date]);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des reservations</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <h1>Liste des reservations</h1>
    <table border="1">
        <tr>
            <th>Membres</th>
            <th>Espace</th>
            <th>Date</th>
            <th>Heure début</th>
            <th>Heure fin</th>
            <th>Coût</th>
            <th>statut</th>
            <th>Modifier</th>
            <th>Annuller</th>
        </tr>
        <?php foreach($reservations as $reservation): ?>
        <tr>
            <td><?= htmlspecialchars($reservation['nom'].' '.$reservation['prenom']) ?></td>
            <td><?= htmlspecialchars($reservation['typee']) ?> <?= htmlspecialchars($reservation['capacite']) ?> Persone</td>
            <td><?= htmlspecialchars($reservation['date_reservation']) ?></td>
            <td><?= htmlspecialchars($reservation['heure_debut']) ?></td>
            <td><?= htmlspecialchars($reservation['heure_fin']) ?></td>
            <td><?= htmlspecialchars($reservation['cout_total']) ?></td>
            <td><?= htmlspecialchars($reservation['statut']) ?></td>
            <td><a href="ModifierReservation.php?id=<?= $reservation['id'] ?>">Modifier</a></td>
            <td><a href="AnnullerReservation.php?id=<?= $reservation['id'] ?>">Annuller</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php">Retour</a>
</body>
</html>