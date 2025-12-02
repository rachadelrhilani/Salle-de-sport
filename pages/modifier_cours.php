<?php
include("../connection/connect.php");
$message = '';
$course_data = null;

// Récupérer l'ID du cours à modifier depuis l'URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connect, $_GET['id']);
    $query = "SELECT * FROM cours WHERE id_cours = '$id'";
    $result = mysqli_query($connect, $query);
    if ($result && mysqli_num_rows($result) == 1) {
        $course_data = mysqli_fetch_assoc($result);
    } else {
        $message = '<div class="alert alert-danger">Cours non trouvé.</div>';
    }
}

// Gérer la soumission du formulaire de modification
if (isset($_POST['modifier_cours']) && $course_data) {
    $id = mysqli_real_escape_string($connect, $_POST['id_cours']);
    $nom = mysqli_real_escape_string($connect, $_POST['nom']);
    $categorie = mysqli_real_escape_string($connect, $_POST['categorie']);
    $date_cours = mysqli_real_escape_string($connect, $_POST['date_cours']);
    $heure = mysqli_real_escape_string($connect, $_POST['heure']);
    $duree = mysqli_real_escape_string($connect, $_POST['duree']);
    $max_participants = mysqli_real_escape_string($connect, $_POST['max_participants']);

    $sql_update = "UPDATE cours SET 
                    nom='$nom', 
                    categorie='$categorie', 
                    date_cours='$date_cours', 
                    heure='$heure', 
                    duree='$duree', 
                    max_participants='$max_participants' 
                   WHERE id_cours='$id'";

    if (mysqli_query($connect, $sql_update)) {
        $message = '<div class="alert alert-success">Le cours a été mis à jour avec succès. <a href="page_cours.php">Retour à la liste</a></div>';
        // Mettre à jour les données affichées après la modification
        $course_data['nom'] = $nom;
        // ... (mettez à jour les autres champs si nécessaire pour l'affichage immédiat)
    } else {
        $message = '<div class="alert alert-danger">Erreur lors de la mise à jour : ' . mysqli_error($connect) . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Cours</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Modifier le Cours</h1>
    <?php echo $message; ?>

    <?php if ($course_data): ?>
    <form method="POST" action="">
        <!-- Champ caché pour l'ID -->
        <input type="hidden" name="id_cours" value="<?php echo htmlspecialchars($course_data['id_cours']); ?>">

        <div class="mb-3">
            <label for="nom" class="form-label">Nom du cours</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($course_data['nom']); ?>" required>
        </div>
        <!-- Répétez pour les autres champs, en utilisant value="..." pour pré-remplir -->
        <div class="mb-3">
            <label for="categorie" class="form-label">Catégorie</label>
            <input type="text" class="form-control" id="categorie" name="categorie" value="<?php echo htmlspecialchars($course_data['categorie']); ?>" required>
        </div>
         <div class="mb-3">
            <label for="date_cours" class="form-label">Date</label>
            <input type="date" class="form-control" id="date_cours" name="date_cours" value="<?php echo htmlspecialchars($course_data['date_cours']); ?>" required>
        </div>
         <div class="mb-3">
            <label for="heure" class="form-label">Heure</label>
            <input type="time" class="form-control" id="heure" name="heure" value="<?php echo htmlspecialchars($course_data['heure']); ?>" required>
        </div>
         <div class="mb-3">
            <label for="duree" class="form-label">Durée (minutes)</label>
            <input type="number" class="form-control" id="duree" name="duree" value="<?php echo htmlspecialchars($course_data['duree']); ?>" required>
        </div>
         <div class="mb-3">
            <label for="max_participants" class="form-label">Max Participants</label>
            <input type="number" class="form-control" id="max_participants" name="max_participants" value="<?php echo htmlspecialchars($course_data['nb_max_participants']); ?>" required>
        </div>

        <button type="submit" name="modifier_cours" class="btn btn-primary">Sauvegarder les modifications</button>
        <a href="cours.php" class="btn btn-secondary">Annuler</a>
    </form>
    <?php endif; ?>
</div>
</body>
</html>
