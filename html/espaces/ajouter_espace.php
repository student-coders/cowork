<?php 
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $type = $_POST['typee'];
    $capacite = $_POST['capacite'];
    $equipements = $_POST['equipements'];
    $prix_heure = $_POST['prix_heure'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO espaces (nom, typee, capacite, equipements, prix_heure) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $typee, $capacite, $equipements, $prix_heure]);
        header("Location: liste_espaces.php");
        exit();
    } catch (PDOException $e) {
        $error = "Erreur lors de l'ajout de l'espace: " . $e->getMessage();
       header("Location: ajouter_espace.php?error=" . urlencode($error));
        exit();
    }
    
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Espace - Coworking Maroc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
   
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ajouter un nouvel espace</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        
                        <form method="post">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom de l'espace</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="type" class="form-label">Type d'espace</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="bureau privé">Bureau privé</option>
                                    <option value="open space">Open space</option>
                                    <option value="salle de réunion">Salle de réunion</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="capacite" class="form-label">Capacité (nombre de personnes)</label>
                                <input type="number" class="form-control" id="capacite" name="capacite" min="1" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="equipements" class="form-label">Équipements disponibles</label>
                                <textarea class="form-control" id="equipements" name="equipements" rows="3"></textarea>
                                <small class="text-muted">Séparez les équipements par des virgules (ex: écran, vidéoprojecteur, tableau blanc)</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="prix_heure" class="form-label">Prix par heure (MAD)</label>
                                <input type="number" class="form-control" id="prix_heure" name="prix_heure" min="0" step="0.01" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                            <a href="liste_espaces.php" class="btn btn-secondary">Annuler</a>
                            <a href="liste_membres.php" class="back-link">Retour à la liste</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>