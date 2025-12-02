<?php
include("../connection/connect.php");
//Afficher le nombre total des equipements et cours
$countequipement = "SELECT COUNT(*) AS total_equipements FROM equipements";
$countcours = "SELECT COUNT(*) AS total_cours FROM cours";
$totalequipement_result = mysqli_query($connect,$countequipement);
$totalcours_result = mysqli_query($connect,$countcours);
if ($totalequipement_result && $totalcours_result) {
    $row_equipement = mysqli_fetch_assoc($totalequipement_result);
    $row_cours = mysqli_fetch_assoc($totalcours_result);
    $total_equipements = $row_equipement['total_equipements'];
    $total_cours = $row_cours['total_cours'];
} 
//Afficher 
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
    body { background:#f7f9fc; }
    .card { border-radius: 12px; }
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
        <canvas id="coursesChart"></canvas>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow p-3">
        <h6 class="text-center">Équipements par type</h6>
        <canvas id="equipmentsChart"></canvas>
      </div>
    </div>

  </div>

</div>



</body>
</html>
