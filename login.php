<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow p-4" style="width: 380px;">
    <h3 class="text-center mb-3">Connexion</h3>

    <form>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" placeholder="Entrez votre email">
      </div>

      <div class="mb-3">
        <label class="form-label">Mot de passe</label>
        <input type="password" class="form-control" placeholder="Entrez votre mot de passe">
      </div>

      <button type="submit" class="btn btn-primary w-100">Se connecter</button>

      <p class="text-center mt-3">
        Pas de compte ?
        <a href="signup.php">Créer un compte</a>
      </p>
    </form>
  </div>
</div>

</body>
</html>
