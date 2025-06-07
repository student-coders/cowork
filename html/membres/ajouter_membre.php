<?php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("INSERT INTO membres (nom, prenom, profession, email, telephone, type_abonnement, date_inscription) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['profession'],
        $_POST['email'],
        $_POST['telephone'],
        $_POST['type_abonnement']
    ]);
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ajouter_membre</title>
</head>
<body>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f7fa;
        margin: 0;
        padding: 20px;
        color: #333;
    }
    
    .container {
        max-width: 600px;
        margin: 30px auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    h1 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 30px;
        font-weight: 600;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #2c3e50;
    }
    
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.3s;
        box-sizing: border-box;
    }
    
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="tel"]:focus,
    select:focus {
        border-color: #3498db;
        outline: none;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }
    
    button[type="submit"] {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        border-radius: 6px;
        cursor: pointer;
        width: 100%;
        font-weight: 500;
        transition: background-color 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    button[type="submit"]:hover {
        background-color: #2980b9;
    }
    
    .success-message {
        background-color: #2ecc71;
        color: white;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        text-align: center;
        display: none;
    }
    
    .required-field::after {
        content: " *";
        color: #e74c3c;
    }
    
    @media (max-width: 768px) {
        .container {
            padding: 20px;
            margin: 15px;
        }
    }
</style>

<div class="container">
    <h1>Ajouter un nouveau membre</h1>
    
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <div class="success-message" style="display: block;">
        Membre ajouté avec succès.
    </div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label for="nom" class="required-field">Nom</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        
        <div class="form-group">
            <label for="prenom" class="required-field">Prénom</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        
        <div class="form-group">
            <label for="profession">Profession</label>
            <input type="text" id="profession" name="profession">
        </div>
        
        <div class="form-group">
            <label for="email" class="required-field">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="tel" id="telephone" name="telephone">
        </div>
        
        <div class="form-group">
            <label for="type_abonnement">Type d'abonnement</label>
            <select id="type_abonnement" name="type_abonnement">
                <option value="journalier">Journalier</option>
                <option value="hebdomadaire">Hebdomadaire</option>
                <option value="mensuel">Mensuel</option>
            </select>
        </div>
        
        <button type="submit">Ajouter le membre</button>
        <a href="index.php" class="back-link">Retour à la liste</a>
    </form>
</body>
</html>