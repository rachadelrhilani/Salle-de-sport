<?php
include("../connection/connect.php");

$message = ''; 

if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($connect, $_GET['delete_id']);
    $sql_delete = "DELETE FROM equipements WHERE id_equipement = '$id'";
    if (mysqli_query($connect, $sql_delete)) {
        $message = '<div class="alert alert-success">L\'équipement a été supprimé avec succès.</div>';
    } else {
        $message = '<div class="alert alert-danger">Erreur lors de la suppression : ' . mysqli_error($connect) . '</div>';
    }
}


if (isset($_POST['ajouter_equipement'])) {
    $nom = mysqli_real_escape_string($connect, $_POST['nom']);
    $type = mysqli_real_escape_string($connect, $_POST['type']);
    $quantite_disponible = mysqli_real_escape_string($connect, $_POST['quantite_disponible']);
    $etat = mysqli_real_escape_string($connect, $_POST['etat']);

    $sql_insert = "INSERT INTO equipements (nom, type, quantite_disponible, etat) 
                   VALUES ('$nom', '$type', '$quantite_disponible', '$etat')";
    
    if (mysqli_query($connect, $sql_insert)) {
        $message = '<div class="alert alert-success">Le nouvel équipement a été ajouté avec succès.</div>';
    } else {
        $message = '<div class="alert alert-danger">Erreur lors de l\'ajout : ' . mysqli_error($connect) . '</div>';
    }
}


$query_equipements = "SELECT * FROM equipements ORDER BY nom ASC";
$result_equipements = mysqli_query($connect, $query_equipements);
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
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <h1>Gestion des Équipements</h1>

    <?php echo $message; ?>


    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEquipmentModal">
      Ajouter un nouvel équipement
    </button>

   
    <div class="card shadow p-3">
        <h3>Liste des Équipements</h3>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Quantité Disponible</th>
                        <th>État</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_equipements && mysqli_num_rows($result_equipements) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result_equipements)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nom']); ?></td>
                                <td><?php echo htmlspecialchars($row['type']); ?></td>
                                <td><?php echo htmlspecialchars($row['quantite_disponible']); ?></td>
                                <td>
                                    <span class="badge bg-<?php 
                                        if ($row['etat'] == 'bon') echo 'success';
                                        elseif ($row['etat'] == 'moyen') echo 'warning';
                                        else echo 'danger';
                                    ?>">
                                        <?php echo htmlspecialchars($row['etat']); ?>
                                    </span>
                                </td>
                                <td>
                                    
                                    <a href="modifier_equipement.php?id=<?php echo $row['id_equipement']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                                    
                                    <a href="?delete_id=<?php echo $row['id_equipement']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet équipement ?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Aucun équipement trouvé.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addEquipmentModal" tabindex="-1" aria-labelledby="addEquipmentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEquipmentModalLabel">Ajouter un nouvel équipement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="">
          <div class="mb-3">
            <label for="nom" class="form-label">Nom de l'équipement</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
          </div>
          <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" class="form-control" id="type" name="type" required>
          </div>
          <div class="mb-3">
            <label for="quantite_disponible" class="form-label">Quantité disponible</label>
            <input type="number" class="form-control" id="quantite_disponible" name="quantite_disponible" required>
          </div>
          <div class="mb-3">
            <label for="etat" class="form-label">État</label>
            <select class="form-select" id="etat" name="etat" required>
                <option value="bon">Bon</option>
                <option value="moyen">Moyen</option>
                <option value="à remplacer">À remplacer</option>
            </select>
          </div>
          <button type="submit" name="ajouter_equipement" class="btn btn-primary">Enregistrer l'équipement</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>
