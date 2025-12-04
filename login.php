<?php
include("./connection/connect.php");
session_start();
$message = '';
if (isset($_POST['seconnecter'])) {
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    $Auth = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
    $query_login = mysqli_query($connect,$Auth);
    $row_login = mysqli_fetch_array($query_login);
    if(mysqli_num_rows($query_login) > 0){
       header("Location: ./pages/dashboard.php");
       $_SESSION['user_con'] = $row_login["nomcomplet"];
       $_SESSION['auth'] = "you are connected";
       $_SESSION['status'] = "you are connected";
       exit();
    }
    else{
      $message = '<div class="alert alert-success">ce email ou password n existe pas</div>';
      $_SESSION['auth'] = "";
    }
}
?>
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
    <?php echo $message; ?>
    <form action="" method="POST">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Entrez votre email">
      </div>

      <div class="mb-3">
        <label class="form-label">Mot de passe</label>
        <input type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe">
      </div>

      <button type="submit" name="seconnecter" class="btn btn-primary w-100">Se connecter</button>

      <p class="text-center mt-3">
        Pas de compte ?
        <a href="signup.php">Créer un compte</a>
      </p>
    </form>
  </div>
</div>

</body>
</html>
