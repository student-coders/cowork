<?php
require '../db.php';


$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: liste_membres.php");
    exit();
}


$stmt = $pdo->prepare("SELECT * FROM membres WHERE id = ?");
$stmt->execute([$id]);
$membre = $stmt->fetch();


if (!$membre) {
    header("Location: liste_membres.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type_abonnement = $_POST['type_abonnement'] ?? '';
    
    
    if (in_array($type_abonnement, ['journalier', 'hebdomadaire', 'mensuel'])) {
        $stmt = $pdo->prepare("UPDATE membres SET type_abonnement = ? WHERE id = ?");
        $stmt->execute([$type_abonnement, $id]);
        
        
        header("Location: liste_membres.php?success=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier abonnement</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --text-color: #2b2d42;
            --light-gray: #f8f9fa;
            --white: #ffffff;
            --border-radius: 8px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--light-gray);
            color: var(--text-color);
            line-height: 1.6;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .form-container {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 2.5rem;
            width: 100%;
            max-width: 500px;
            transition: var(--transition);
        }
        
        .form-title {
            color: var(--text-color);
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 600;
            font-size: 1.75rem;
            position: relative;
        }
        
        .form-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: var(--accent-color);
            margin: 0.75rem auto 0;
            border-radius: 2px;
        }
        
        .member-card {
            background: var(--light-gray);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            border-left: 4px solid var(--accent-color);
        }
        
        .member-name {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .member-detail {
            display: flex;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        
        .member-detail strong {
            min-width: 100px;
            display: inline-block;
            color: #6c757d;
        }
        
        .form-group {
            margin-bottom: 1.75rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 500;
            font-size: 1rem;
        }
        
        .select-wrapper {
            position: relative;
        }
        
        .select-wrapper::after {
            content: '⌄';
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            pointer-events: none;
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        
        select {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid #e0e0e0;
            border-radius: var(--border-radius);
            font-size: 1rem;
            appearance: none;
            background-color: var(--white);
            transition: var(--transition);
            cursor: pointer;
        }
        
        select:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(72, 149, 239, 0.2);
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            border-radius: var(--border-radius);
            cursor: pointer;
            width: 100%;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            margin-top: 1.5rem;
            color: #6c757d;
            text-decoration: none;
            transition: var(--transition);
            font-size: 0.9rem;
        }
        
        .back-link:hover {
            color: var(--primary-color);
        }
        
        .back-link::before {
            content: '←';
            margin-right: 0.5rem;
        }
        
        @media (max-width: 576px) {
            body {
                padding: 1rem;
            }
            
            .form-container {
                padding: 1.5rem;
            }
            
            .form-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1 class="form-title">Modifier l'abonnement</h1>
        
        <div class="member-card">
            <div class="member-name"><?= htmlspecialchars($membre['prenom']) ?> <?= htmlspecialchars($membre['nom']) ?></div>
            <div class="member-detail"><strong>Email:</strong> <?= htmlspecialchars($membre['email']) ?></div>
            <div class="member-detail"><strong>Téléphone:</strong> <?= htmlspecialchars($membre['telephone']) ?></div>
            <div class="member-detail"><strong>Abonnement actuel:</strong> <?= ucfirst($membre['type_abonnement']) ?></div>
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label for="type_abonnement">Nouveau type d'abonnement</label>
                <div class="select-wrapper">
                    <select id="type_abonnement" name="type_abonnement" required>
                        <option value="journalier" <?= $membre['type_abonnement'] == 'journalier' ? 'selected' : '' ?>>Journalier</option>
                        <option value="hebdomadaire" <?= $membre['type_abonnement'] == 'hebdomadaire' ? 'selected' : '' ?>>Hebdomadaire</option>
                        <option value="mensuel" <?= $membre['type_abonnement'] == 'mensuel' ? 'selected' : '' ?>>Mensuel</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 8px;">
                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                </svg>
                Mettre à jour
            </button>
        </form>
        
        <a href="liste_membres.php" class="back-link">Retour à la liste</a>
    </div>
</body>
</html>