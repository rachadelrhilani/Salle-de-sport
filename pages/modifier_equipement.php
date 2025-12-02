<?php
include("../connection/connect.php");
$message = '';
$equipment_data = null;

// Récupérer l'ID de l'équipement à modifier
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connect, $_GET['id']);
    $query = "SELECT * FROM equipements WHERE id_equipement = '$id'";
    $result = mysqli_query($connect, $query);
    if ($result && mysqli_num_rows($result) == 1) {
        $equipment_data = mysqli_fetch_assoc($result);
    } else {
        $message = '<div class="alert alert-danger">Équipement non trouvé.</div>';
    }
}

// Gérer la soumission du formulaire de modification
if (isset($_POST['modifier_equipement']) && $equipment_data) {
    $id = mysqli_real_escape_string($connect, $_POST['id_equipement']);
    $nom = mysqli_real_escape_string($connect, $_POST['nom']);
    $type = mysqli_real_escape_string($connect, $_POST['type']);
    $quantite_disponible = mysqli_real_escape_string($connect, $_POST['quantite_disponible']);
    $etat = mysqli_real_escape_string($connect, $_POST['etat']);

    $sql_update = "UPDATE equipements SET 
                    nom='$nom', 
                    type='$type', 
                    quantite_disponible='$quantite_disponible', 
                    etat='$etat' 
                   WHERE id_equipement='$id'";

    if (mysqli_query($connect, $sql_update)) {
        $message = '<div class="alert alert-success">L\'équipement a été mis à jour avec succès. <a href="page_equipements.php">Retour à la liste</a></div>';
    } else {
        $message = '<div class="alert alert-danger">Erreur lors de la mise à jour : ' . mysqli_error($connect) . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Équipement</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Modifier l'Équipement</h1>
    <?php echo $message; ?>

    <?php if ($equipment_data): ?>
    <form method="POST" action="">
        <input type="hidden" name="id_equipement" value="<?php echo htmlspecialchars($equipment_data['id_equipement']); ?>">

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de l'équipement</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($equipment_data['nom']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" class="form-control" id="type" name="type" value="<?php echo htmlspecialchars($equipment_data['type']); ?>" required>
        </div>
         <div class="mb-3">
            <label for="quantite_disponible" class="form-label">Quantité disponible</label>
            <input type="number" class="form-control" id="quantite_disponible" name="quantite_disponible" value="<?php echo htmlspecialchars($equipment_data['quantite_disponible']); ?>" required>
        </div>
         <div class="mb-3">
            <label for="etat" class="form-label">État</label>
            <select class="form-select" id="etat" name="etat" required>
                <option value="bon" <?php if ($equipment_data['etat'] == 'bon') echo 'selected'; ?>>Bon</option>
                <option value="moyen" <?php if ($equipment_data['etat'] == 'moyen') echo 'selected'; ?>>Moyen</option>
                <option value="à remplacer" <?php if ($equipment_data['etat'] == 'à remplacer') echo 'selected'; ?>>À remplacer</option>
            </select>
        </div>

        <button type="submit" name="modifier_equipement" class="btn btn-primary">Sauvegarder les modifications</button>
        <a href="equipements.php" class="btn btn-secondary">Annuler</a>
    </form>
    <?php endif; ?>
</div>
</body>
</html>
