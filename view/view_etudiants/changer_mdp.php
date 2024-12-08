<?php
include_once '../../repository/repositorySchumanConnect/ProfilRepository.php';
include_once '../../utils/flash.php';
include_once '../../init.php';
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
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
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
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
