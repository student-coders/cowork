<?php
require '../db.php';

$membres = $pdo->query("SELECT * FROM membres ORDER BY date_inscription DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des membres</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        
        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
            display: inline-block;
        }
        
        .table-container {
            max-width: 100%;
            overflow-x: auto;
            margin: 0 auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background: white;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            font-size: 0.9em;
            min-width: 800px;
        }
        
        th {
            background-color: #3498db;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8em;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: middle;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        tr:hover {
            background-color: #f1f7fd;
        }
        
        td a {
            color: #3498db;
            text-decoration: none;
            margin: 0 5px;
            padding: 5px 8px;
            border-radius: 4px;
            transition: all 0.3s;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        td a:hover {
            background-color: #e3f2fd;
        }
        
        td a[onclick] {
            color: #e74c3c;
        }
        
        td a[onclick]:hover {
            background-color: #fde8e6;
        }
        
        td:nth-last-child(2) {
            font-family: monospace;
            font-size: 0.85em;
            color: #666;
        }
        
        .action-buttons {
            white-space: nowrap;
        }
        
        @media (max-width: 768px) {
            .table-container {
                border-radius: 0;
                box-shadow: none;
            }
            
            h2 {
                font-size: 1.3em;
            }
            
            th, td {
                padding: 8px 10px;
                font-size: 0.85em;
            }
            
            td a {
                padding: 3px 5px;
                font-size: 0.8em;
            }
        }
        
        .empty-message {
            text-align: center;
            padding: 30px;
            color: #7f8c8d;
            font-style: italic;
        }
        
        .add-member-btn {
            display: block;
            text-align: center;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #2ecc71;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            width: fit-content;
            transition: background-color 0.3s;
        }
        
        .add-member-btn:hover {
            background-color: #27ae60;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="table-container">
        <h2>Liste des membres</h2>
        
        <a href="ajouter_membre.php" class="add-member-btn">
            <i class="fas fa-user-plus"></i> Ajouter un membre
        </a>
        
        <?php if (empty($membres)): ?>
            <div class="empty-message">Aucun membre inscrit pour le moment</div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Profession</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Abonnement</th>
                        <th>Inscription</th>
                        <th class="action-buttons">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($membres as $m): ?>
                    <tr>
                        <td><?= $m['id'] ?></td>
                        <td><?= htmlspecialchars($m['nom']) ?></td>
                        <td><?= htmlspecialchars($m['prenom']) ?></td>
                        <td><?= htmlspecialchars($m['profession']) ?></td>
                        <td><?= htmlspecialchars($m['email']) ?></td>
                        <td><?= htmlspecialchars($m['telephone']) ?></td>
                        <td><?= ucfirst($m['type_abonnement']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($m['date_inscription'])) ?></td>
                        <td class="action-buttons">
                            <a href="modifier_abonnement.php?id=<?= $m['id'] ?>" title="Modifier">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <a href="supprimer_membre.php?id=<?= $m['id'] ?>" 
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?');" 
                               title="Supprimer">
                                <i class="fas fa-trash-alt"></i> Supprimer
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>