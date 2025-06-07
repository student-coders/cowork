<?php 
require_once '../db.php';

$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$espaceId = isset($_GET['id']) ? $_GET['id'] : null;

// Fetch all spaces for dropdown
$stmt = $pdo->query("SELECT * FROM espaces ORDER BY nom");
$espaces = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch selected space details if ID is provided
$selectedSpace = null;
if ($espaceId) {
    $stmt = $pdo->prepare("SELECT * FROM espaces WHERE id = ?");
    $stmt->execute([$espaceId]);
    $selectedSpace = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch reservations for selected space and date
$reservations = [];
if ($selectedSpace) {
    $stmt = $pdo->prepare("
        SELECT r.*, m.nom AS membre_nom, m.prenom AS membre_prenom 
        FROM reservations r 
        JOIN membres m ON r.membre_id = m.id 
        WHERE r.espace_id = ? AND r.date_reservation = ? AND r.statut = 'confirmée'
        ORDER BY r.heure_debut
    ");
    $stmt->execute([$espaceId, $selectedDate]);
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Generate time slots (8:00 to 20:00)
$timeSlots = [];
for ($hour = 8; $hour <= 20; $hour++) {
    $timeSlots[] = sprintf("%02d:00", $hour);
    $timeSlots[] = sprintf("%02d:30", $hour);
}
array_pop($timeSlots); // Remove 20:30
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disponibilité des Espaces - Coworking Maroc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    
    
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Disponibilité des Espaces</h2>
            <a href="liste_espaces.php" class="btn btn-secondary">Retour à la liste</a>
        </div>
        
        <div class="card mb-4">
            <div class="card-body">
                <form method="get" class="row g-3">
                    <div class="col-md-5">
                        <label for="id" class="form-label">Espace</label>
                        <select class="form-select" id="id" name="id" required>
                            <option value="">Sélectionnez un espace</option>
                            <?php foreach ($espaces as $espace): ?>
                                <option value="<?= $espace['id'] ?>" <?= $espaceId == $espace['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($espace['nom']) ?> (<?= ucfirst($espace['type']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?= $selectedDate ?>" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Vérifier</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php if ($selectedSpace): ?>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Disponibilité de <?= htmlspecialchars($selectedSpace['nom']) ?> 
                        (<?= ucfirst($selectedSpace['type']) ?>) 
                        le <?= date('d/m/Y', strtotime($selectedDate)) ?>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Heure</th>
                                    <th>Statut</th>
                                    <th>Réservé par</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($timeSlots as $time): 
                                    $isReserved = false;
                                    $reservedBy = '';
                                    
                                    foreach ($reservations as $reservation) {
                                        $start = strtotime($reservation['heure_debut']);
                                        $end = strtotime($reservation['heure_fin']);
                                        $current = strtotime($time);
                                        
                                        if ($current >= $start && $current < $end) {
                                            $isReserved = true;
                                            $reservedBy = htmlspecialchars($reservation['membre_prenom'] . ' ' . $reservation['membre_nom']);
                                            break;
                                        }
                                    }
                                ?>
                                    <tr class="<?= $isReserved ? 'table-danger' : 'table-success' ?>">
                                        <td><?= $time ?></td>
                                        <td><?= $isReserved ? 'Réservé' : 'Disponible' ?></td>
                                        <td><?= $isReserved ? $reservedBy : '-' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        <h5>Informations sur l'espace:</h5>
                        <ul>
                            <li>Capacité: <?= $selectedSpace['capacite'] ?> personnes</li>
                            <li>Prix par heure: <?= number_format($selectedSpace['prix_heure'], 2) ?> MAD</li>
                            <li>Équipements: <?= $selectedSpace['equipements'] ? htmlspecialchars($selectedSpace['equipements']) : 'Aucun' ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

   
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>