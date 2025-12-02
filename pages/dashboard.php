<?php
include("../connection/connect.php");
//Afficher le nombre total des equipements et cours
$countequipement = "SELECT COUNT(*) AS total_equipements FROM equipements";
$countcours = "SELECT COUNT(*) AS total_cours FROM cours";
$totalequipement_result = mysqli_query($connect, $countequipement);
$totalcours_result = mysqli_query($connect, $countcours);
if ($totalequipement_result && $totalcours_result) {
  $row_equipement = mysqli_fetch_assoc($totalequipement_result);
  $row_cours = mysqli_fetch_assoc($totalcours_result);
  $total_equipements = $row_equipement['total_equipements'];
  $total_cours = $row_cours['total_cours'];
}
//Afficher 
$query_repartition_equipement = "
    SELECT type As type_equipement, COUNT(*) AS count_equipement
    FROM equipements
    GROUP BY type
    ORDER BY count_equipement DESC
";
$result_repartition_equipement = mysqli_query($connect, $query_repartition_equipement);

if (!$result_repartition_equipement) {
  echo "Erreur lors de la récupération de la répartition des équipements : " . mysqli_error($connect);
}
//Récupération de la répartition des cours par type
$query_repartition_cours = "
    SELECT nom AS type_cours, COUNT(*) AS count_cours
    FROM cours
    GROUP BY nom
    ORDER BY count_cours DESC
";
$result_repartition_cours = mysqli_query($connect, $query_repartition_cours);

if (!$result_repartition_cours) {
  echo "Erreur lors de la récupération de la répartition des cours : " . mysqli_error($connect);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    body {
      background: #f7f9fc;
    }

    .card {
      border-radius: 12px;
    }
  </style>
</head>

<body>

  <div class="container py-4">

    <h2 class="fw-bold mb-4">Dashboard</h2>


    <div class="row g-4">
      <div class="col-md-6">
        <div class="card shadow p-4">
          <h6>Total des Cours</h6>
          <h2 class="text-primary fw-bold"><?php echo $total_cours ?></h2>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card shadow p-4">
          <h6>Total des Équipements</h6>
          <h2 class="text-success fw-bold"><?php echo $total_equipements ?></h2>
        </div>
      </div>
    </div>

    <div class="row mt-4 g-4">

      
      <div class="col-md-6">
        <div class="card shadow p-3">
          <h6 class="text-center">Cours par type</h6>

          
          <ul class="list-group">
            <?php if ($result_repartition_cours): ?>
              <?php while ($row = mysqli_fetch_assoc($result_repartition_cours)): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <?php echo htmlspecialchars($row['type_cours']); ?>
                  <span class="badge bg-primary rounded-pill"><?php echo htmlspecialchars($row['count_cours']); ?></span>
                </li>
              <?php endwhile; ?>
            <?php endif; ?>
          </ul>

        </div>
      </div>

      
      <div class="col-md-6">
        <div class="card shadow p-3">
          <h6 class="text-center">Équipements par type</h6>

         
          <ul class="list-group">
            <?php if ($result_repartition_equipement): ?>
              <?php while ($row = mysqli_fetch_assoc($result_repartition_equipement)): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <?php echo htmlspecialchars($row['type_equipement']); ?>
                  <span class="badge bg-primary rounded-pill"><?php echo htmlspecialchars($row['count_equipement']); ?></span>
                </li>
              <?php endwhile; ?>
            <?php endif; ?>
          </ul>

        </div>
      </div>

    </div>


  </div>



</body>

</html>