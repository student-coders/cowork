<?php
require ('db.php');

$id=$_GET['id'];
$espaces=$PDO->query("SELECT * from espaces")->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST')  {
    
    $type=$_POST['typee'];
    $date_reservation=$_POST['date_reservation'];
    $heure_deb=$_POST['heure_debut'];
    $heure_fin=$_POST['heure_fin'];
    $statut='confirmer';

  
    $select=$PDO->prepare("SELECT id , prix_heure from espaces where typee=?");
    $select->execute([$type]);
    $row=$select->fetch();

   if ($row) {
    $tcheck=$PDO->prepare("SELECT count(id) AS count from reservations where date_reservation=? AND (heure_debut BETWEEN ? AND ?) AND 
    statut=? AND espace_id in ( SELECT espace_id from espaces where typee=?)");
    $tcheck->execute([$date_reservation,$heure_deb,$heure_fin,$statut,$type]);
    $row1=$tcheck->fetch();
    
    $cout=((strtotime($heure_fin)-strtotime($heure_deb))/3600)*($row['prix_heure']);

    if ($row1) {
        if ($row1['count']==0) {
            $stmt=$PDO->prepare("UPDATE reservations set espace_id=?, date_reservation=?, heure_debut=?, heure_fin=?, cout_total=?
            where id=?");
            $stmt->execute([$row['id'],$date_reservation,$heure_deb,$heure_fin,$cout,$id]);
            header('location:ListeRéservation.php');
        }
        else {
                die ("<p style='color:red;'>se type qui choisi est ne pas disbonible a ce date changer la date ou temps</p>");
        }
    }
   
   }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style1.css">

<form action="" method="POST" >
  <h2 class="login-title">Réservation</h2>
  
    <div class="form-group mb-3">
        <label for="typee">Choisir un type d'espace </label><br><br>
        <select name="typee" class="form-control" required>
            <?php foreach($espaces as $espace): ?>
                <option value="<?= htmlspecialchars($espace['typee']) ?>">
                    <?= htmlspecialchars($espace['typee']) ?>  <?= $espace['capacite'] ?> Personne  <?= $espace['prix_heure'] ?> DH par heure
                </option>
            <?php endforeach; ?>
        </select><br><br>
    </div>
    <div class="form-group mb-3">
        <label for="date_reservation">Date </label><br><br>
        <input type="Date" name="date_reservation" class="form-control" required><br><br>
    </div>
    <div class="form-group mb-3">
        <label for="heure_debut">Heure de début </label><br><br>
        <input type="time" name="heure_debut" class="form-control" required><br><br>
    </div>

    <div class="form-group mb-3">
        <label for="heure_fin">Heure de fin </label><br><br>
        <input type="time" name="heure_fin" class="form-control" required><br><br>
    </div>

    <button type="submit" class="btn btn-primary">Modifier</button><br><br>
    <a href="ListeRéservation.php">Retour</a>
</form>
