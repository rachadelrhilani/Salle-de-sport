
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
        <h2 class="text-primary fw-bold"><?= $totalCours ?></h2>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow p-4">
        <h6>Total des Équipements</h6>
        <h2 class="text-success fw-bold"><?= $totalEquipements ?></h2>
      </div>
    </div>
  </div>

  <!-- GRAPHS -->
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

<script>
  // 📌 Récupération des données PHP → JS
  const coursLabels = <?= json_encode(array_column($coursTypes, "type")) ?>;
  const coursData = <?= json_encode(array_column($coursTypes, "total")) ?>;

  const equipLabels = <?= json_encode(array_column($equipementsTypes, "type")) ?>;
  const equipData = <?= json_encode(array_column($equipementsTypes, "total")) ?>;

  // 📊 Graphique cours
  new Chart(document.getElementById("coursesChart"), {
    type: "pie",
    data: {
      labels: coursLabels,
      datasets: [{ data: coursData }]
    }
  });

  // 📊 Graphique équipements
  new Chart(document.getElementById("equipmentsChart"), {
    type: "doughnut",
    data: {
      labels: equipLabels,
      datasets: [{ data: equipData }]
    }
  });
</script>

</body>
</html>
