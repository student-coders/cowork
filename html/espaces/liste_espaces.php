<?php 
require_once '../db.php';


$stmt = $pdo->query("SELECT * FROM espaces ORDER BY typee, nom");
$espaces = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Espaces - Coworking Maroc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Liste des Espaces</h2>
            <div>
                <a href="ajouter_espace.php" class="btn btn-success">Ajouter un espace</a>
                <a href="disponibilite_espace.php" class="btn btn-info">Voir disponibilités</a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Type</th>
                                <th>Capacité</th>
                                <th>Équipements</th>
                                <th>Prix/heure</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($espaces as $espace): ?>
                                <tr>
                                    <td><?= $espace['id'] ?></td>
                                    <td><?= htmlspecialchars($espace['nom']) ?></td>
                                    <td>
                                        <span class="badge 
                                            <?= $espace['type'] === 'bureau privé' ? 'bg-primary' : 
                                               ($espace['type'] === 'open space' ? 'bg-success' : 'bg-info') ?>">
                                            <?= ucfirst($espace['type']) ?>
                                        </span>
                                    </td>
                                    <td><?= $espace['capacite'] ?> personnes</td>
                                    <td><?= htmlspecialchars($espace['equipements']) ?></td>
                                    <td><?= number_format($espace['prix_heure'], 2) ?> MAD</td>
                                    <td>
                                        <a href="disponibilite_espace.php?id=<?= $espace['id'] ?>" class="btn btn-sm btn-info">Disponibilité</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>