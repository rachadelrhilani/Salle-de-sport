<?php
include("../connection/connect.php");

$message = ''; 

/* suppression(délier un équipement d’un cours) */
if (isset($_GET['unlink_cours']) && isset($_GET['unlink_equip'])) {
    $id_cours = mysqli_real_escape_string($connect, $_GET['unlink_cours']);
    $id_equipement = mysqli_real_escape_string($connect, $_GET['unlink_equip']);

    $delete_sql = "DELETE FROM cours_equipements 
                   WHERE id_cours='$id_cours' AND id_equipement='$id_equipement'";

    if (mysqli_query($connect, $delete_sql)) {
        $message = '<div class="alert alert-success">Équipement délié du cours avec succès.</div>';
    } else {
        $message = '<div class="alert alert-danger">Erreur lors du déliage : ' . mysqli_error($connect) . '</div>';
    }
}

/*AJOUT / LIER (cours + équipement)*/
if (isset($_POST['lier'])) {
    $cours = mysqli_real_escape_string($connect, $_POST['cours']);
    $equip = mysqli_real_escape_string($connect, $_POST['equip']);
    $quantite = mysqli_real_escape_string($connect, $_POST['quantite']);

    $sql = "INSERT INTO cours_equipements (id_cours, id_equipement, quantite_necessaire)
            VALUES ('$cours', '$equip', '$quantite')
            ON DUPLICATE KEY UPDATE quantite_necessaire='$quantite'";

    if (mysqli_query($connect, $sql)) {
        $message = '<div class="alert alert-success">Équipement lié avec succès.</div>';
    } else {
        $message = '<div class="alert alert-danger">Erreur : ' . mysqli_error($connect) . '</div>';
    }
}

/*filtres */
$filtre_cours = $_GET['cours'] ?? "";
$filtre_equip = $_GET['equip'] ?? "";

/*listes de selection*/
$cours_res = mysqli_query($connect, "SELECT * FROM cours ORDER BY nom ASC");
$equip_res = mysqli_query($connect, "SELECT * FROM equipements ORDER BY nom ASC");

/*requette d'association*/
if ($filtre_cours != "") {
    $query = "
        SELECT c.nom AS cours, e.nom AS equipement, ce.quantite_necessaire, ce.id_cours, ce.id_equipement
        FROM cours_equipements ce
        JOIN cours c ON c.id_cours = ce.id_cours
        JOIN equipements e ON e.id_equipement = ce.id_equipement
        WHERE ce.id_cours = '$filtre_cours'
    ";

} elseif ($filtre_equip != "") {
    $query = "
        SELECT c.nom AS cours, e.nom AS equipement, ce.quantite_necessaire, ce.id_cours, ce.id_equipement
        FROM cours_equipements ce
        JOIN cours c ON c.id_cours = ce.id_cours
        JOIN equipements e ON e.id_equipement = ce.id_equipement
        WHERE ce.id_equipement = '$filtre_equip'
    ";

} else {
    $query = "
        SELECT c.nom AS cours, e.nom AS equipement, ce.quantite_necessaire, ce.id_cours, ce.id_equipement
        FROM cours_equipements ce
        JOIN cours c ON c.id_cours = ce.id_cours
        JOIN equipements e ON e.id_equipement = ce.id_equipement
    ";
}

$result_assoc = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Cours & Équipements</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<style>
    .w-25{
      width:70px !important;
    }
</style>
<body class="bg-light">
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
    <h2>Gestion Cours & Équipements</h2>

    <?= $message ?>

    
    <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#lierModal">
        Lier un équipement à un cours
    </button>

    <div class="modal fade" id="lierModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <form method="POST">
            <div class="modal-header">
              <h5 class="modal-title">Associer un équipement</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label>Cours :</label>
                <select name="cours" class="form-select mb-3">
                    <?php while ($c = mysqli_fetch_assoc($cours_res)): ?>
                        <option value="<?= $c['id_cours'] ?>"><?= $c['nom'] ?></option>
                    <?php endwhile; ?>
                </select>

                <label>Équipement :</label>
                <select name="equip" class="form-select mb-3">
                    <?php while ($e = mysqli_fetch_assoc($equip_res)): ?>
                        <option value="<?= $e['id_equipement'] ?>"><?= $e['nom'] ?></option>
                    <?php endwhile; ?>
                </select>

                <label>Quantité nécessaire :</label>
                <input type="number" name="quantite" class="form-control" min="1" required>
            </div>

            <div class="modal-footer">
              <button type="submit" name="lier" class="btn btn-primary">Lier</button>
            </div>
          </form>

        </div>
      </div>
    </div>

    
    <div class="card p-3 mb-4">
        <form method="GET" class="row g-3">

            <div class="col-md-5">
                <label>Filtrer par cours</label>
                <select name="cours" class="form-select">
                    <option value="">-- Tous --</option>
                    <?php 
                    $cours_res = mysqli_query($connect, "SELECT * FROM cours ORDER BY nom");
                    while ($c = mysqli_fetch_assoc($cours_res)): ?>
                        <option value="<?= $c['id_cours'] ?>" <?= ($filtre_cours == $c['id_cours'])?'selected':'' ?>>
                            <?= $c['nom'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="col-md-5">
                <label>Filtrer par équipement</label>
                <select name="equip" class="form-select">
                    <option value="">-- Tous --</option>
                    <?php 
                    $equip_res = mysqli_query($connect, "SELECT * FROM equipements ORDER BY nom");
                    while ($e = mysqli_fetch_assoc($equip_res)): ?>
                        <option value="<?= $e['id_equipement'] ?>" <?= ($filtre_equip == $e['id_equipement'])?'selected':'' ?>>
                            <?= $e['nom'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-secondary w-100">Filtrer</button>
            </div>

        </form>
    </div>

    
    <div class="card p-3">
        <h4>Associations</h4>

        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th>Cours</th>
                    <th>Équipement</th>
                    <th>Quantité</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php if (mysqli_num_rows($result_assoc) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result_assoc)): ?>
                    <tr>
                        <td><?= $row['cours'] ?></td>
                        <td><?= $row['equipement'] ?></td>
                        <td><?= $row['quantite_necessaire'] ?></td>
                        <td>
                            <a href="?unlink_cours=<?= $row['id_cours'] ?>&unlink_equip=<?= $row['id_equipement'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Supprimer cette association ?')">
                                Délier
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">Aucune association trouvée.</td></tr>
            <?php endif; ?>

            </tbody>
        </table>
    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
