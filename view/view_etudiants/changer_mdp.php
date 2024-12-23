<?php
include_once '../../repository/repositorySchumanConnect/ProfilRepository.php';
include_once '../../utils/flash.php';
include_once '../../init.php';
include_once '../../repository/repositorySchumanConnect/SocietyRepository.php';
display_flash_message();

$userId = $_SESSION['id_users']; 
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];

    $passwordUpdated = ProfilRepository::changePassword($userId, $oldPassword, $newPassword);

    if ($passwordUpdated === true) {
        set_flash_message("Mot de passe modifié avec succès", "success");
        header("Location: ./accueil.php");
        exit();
    } elseif ($passwordUpdated) {
        set_flash_message($passwordUpdated, "error"); 
        header("Location: ./accueil.php");
    } else {
        set_flash_message("L'ancien mot de passe est incorrect", "error");
        header("Location: ./accueil.php");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changer le Mot de Passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/home_page_SchumanLink.css">
    <link rel="stylesheet" href="../../public/css/base_twig_accueil.css"> 
</head>
<body>
  

<?php include_once '../../public/layouts/accueil_base.php' ?>

<main class="main-content">
<div class="d-flex align-items-center justify-content-center vh-200">
    <div class="card" style="width: 100%; max-width: 600px;">
        <div class="card-header text-center">Changer le Mot de Passe</div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="old_password" class="form-label">Ancien Mot de Passe</label>
                    <input type="password" id="old_password" name="old_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">Nouveau Mot de Passe</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Modifier le mot de passe</button>
                </div>
            </form>
        </div>
    </div>
</div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
