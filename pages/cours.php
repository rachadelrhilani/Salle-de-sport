<?php
include("../connection/connect.php");

$message = ''; 

// supprimer un cours
if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($connect, $_GET['delete_id']);
    $sql_delete = "DELETE FROM cours WHERE id_cours = '$id'";
    if (mysqli_query($connect, $sql_delete)) {
        $message = '<div class="alert alert-success">Le cours a été supprimé avec succès.</div>';
    } else {
        $message = '<div class="alert alert-danger">Erreur lors de la suppression : ' . mysqli_error($connect) . '</div>';
    }
}

// ajouter un cours
if (isset($_POST['ajouter_cours'])) {
    $nom = mysqli_real_escape_string($connect, $_POST['nom']);
    $categorie = mysqli_real_escape_string($connect, $_POST['categorie']);
    $date_cours = mysqli_real_escape_string($connect, $_POST['date_cours']);
    $heure = mysqli_real_escape_string($connect, $_POST['heure']);
    $duree = mysqli_real_escape_string($connect, $_POST['duree']);
    $max_participants = mysqli_real_escape_string($connect, $_POST['max_participants']);

    $sql_insert = "INSERT INTO cours (nom, categorie, date_cours, heure, duree, nb_max_participants) 
                   VALUES ('$nom', '$categorie', '$date_cours', '$heure', '$duree', '$max_participants')";
    
    if (mysqli_query($connect, $sql_insert)) {
        $message = '<div class="alert alert-success">Le nouveau cours a été ajouté avec succès.</div>';
    } else {
        $message = '<div class="alert alert-danger">Erreur lors de l\'ajout : ' . mysqli_error($connect) . '</div>';
    }
}


$query_cours = "SELECT * FROM cours ORDER BY date_cours DESC";
$result_cours = mysqli_query($connect, $query_cours);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

  <style>
    body {
      background: #f7f9fc;
    }

    .card {
      border-radius: 12px;
    }
    .w-25{
      width:70px !important;
    }
  </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a href="dashboard.php"><img src="../image/logo.jpg" class="w-25" alt="logo"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-collapse-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-end" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="cours.php">Les Cours</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="equipements.php">Les Équipements</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="equipement_cours.php">Equipement&cours</a>
        </li>
        <a href="../login.php" class="btn btn-primary">Se Deconnecter</a>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <h1>Gestion des Cours</h1>

    <?php echo $message; ?>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCourseModal">
      Ajouter un nouveau cours
    </button>

    <a href="export_pdf.php" class="btn btn-secondary mb-3">Exporter en PDF</a>

    <div class="card shadow p-3">
        <h3>Liste des Cours</h3>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Durée (min)</th>
                        <th>Max Participants</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_cours && mysqli_num_rows($result_cours) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result_cours)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nom']); ?></td>
                                <td><?php echo htmlspecialchars($row['categorie']); ?></td>
                                <td><?php echo htmlspecialchars($row['date_cours']); ?></td>
                                <td><?php echo htmlspecialchars($row['heure']); ?></td>
                                <td><?php echo htmlspecialchars($row['duree']); ?></td>
                                <td><?php echo htmlspecialchars($row['nb_max_participants']); ?></td>
                                <td>
                                    
                                    <a href="modifier_cours.php?id=<?php echo $row['id_cours']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                                    
                                    <a href="?delete_id=<?php echo $row['id_cours']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Aucun cours trouvé.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCourseModalLabel">Ajouter un nouveau cours</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="">
          <div class="mb-3">
            <label for="nom" class="form-label">Nom du cours</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
          </div>
          <div class="mb-3">
            <label for="categorie" class="form-label">Catégorie</label>
            <input type="text" class="form-control" id="categorie" name="categorie" required>
          </div>
          <div class="mb-3">
            <label for="date_cours" class="form-label">Date</label>
            <input type="date" class="form-control" id="date_cours" name="date_cours" required>
          </div>
          <div class="mb-3">
            <label for="heure" class="form-label">Heure</label>
            <input type="time" class="form-control" id="heure" name="heure" required>
          </div>
           <div class="mb-3">
            <label for="duree" class="form-label">Durée (minutes)</label>
            <input type="number" class="form-control" id="duree" name="duree" required>
          </div>
           <div class="mb-3">
            <label for="max_participants" class="form-label">Max Participants</label>
            <input type="number" class="form-control" id="max_participants" name="max_participants" required>
          </div>
          <button type="submit" name="ajouter_cours" class="btn btn-primary">Enregistrer le cours</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="card p-3 mt-4">
    <h3>Statistiques</h3>
    <canvas id="chartCategorie"></canvas>
</div>
<?php
$query_chart = "SELECT categorie, COUNT(*) AS total FROM cours GROUP BY categorie";
$result_chart = mysqli_query($connect, $query_chart);

$categories = [];
$totaux = [];

while ($row = mysqli_fetch_assoc($result_chart)) {
    $categories[] = $row['categorie'];
    $totaux[] = $row['total'];
}
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartCategorie').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($categories); ?>,
        datasets: [{
            label: 'Nombre de cours par categorie',
            data: <?php echo json_encode($totaux); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    }
});
</script>
</body>
</html>
