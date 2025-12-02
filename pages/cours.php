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
    .w-25{
      width:70px !important;
    }
  </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <img src="../image/logo.jpg" class="w-25" alt="logo">
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
    <h1>Gestion des Cours</h1>

    <?php echo $message; ?>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCourseModal">
      Ajouter un nouveau cours
    </button>

    <!-- TABLEAU DE LA LISTE DES COURS -->
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
                                <td><?php echo htmlspecialchars($row['max_participants']); ?></td>
                                <td>
                                    <!-- Lien Modifier (utilisera un autre fichier pour le formulaire de modif) -->
                                    <a href="modifier_cours.php?id=<?php echo $row['id_cours']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                                    <!-- Lien Supprimer (utilise JS pour confirmation) -->
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
